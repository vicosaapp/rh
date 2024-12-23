<?php

namespace App\Http\Controllers\Admin;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        if (permission::permitted('employee-add')=='fail'){ return redirect()->route('denied'); }

        try {
            DB::beginTransaction();

            // Pega o ID do usuário atual
            $current_user_id = auth()->id();
            
            \Log::info('Criando funcionário:', [
                'user_id' => $current_user_id,
                'user_email' => auth()->user()->email
            ]);

            // Verifica se o usuário está autenticado
            if (!$current_user_id) {
                throw new \Exception('Usuário não está autenticado');
            }

            $v = $request->validate([
                'lastname' => 'required|max:155',
                'firstname' => 'required|max:155',
                // ... outras validações ...
            ]);

            // Verifica ID duplicado
            $is_idno_taken = table::companydata()->where('idno', mb_strtoupper($request->idno))->exists();
            if ($is_idno_taken) {
                return redirect('admin/employee/add')->with('error', trans("The ID number is already used"));
            }

            // Processa a imagem
            $name = null;
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/assets/faces/', $name);
            }

            // Insere com o ID do usuário atual
            $peopleData = [
                'lastname' => mb_strtoupper($request->lastname),
                'firstname' => mb_strtoupper($request->firstname),
                'mi' => mb_strtoupper($request->mi),
                'age' => $request->age,
                'gender' => mb_strtoupper($request->gender),
                'emailaddress' => mb_strtolower($request->emailaddress),
                'civilstatus' => mb_strtoupper($request->civilstatus),
                'mobileno' => $request->mobileno,
                'birthday' => date("Y-m-d", strtotime($request->birthday)),
                'birthplace' => mb_strtoupper($request->birthplace),
                'nationalid' => mb_strtoupper($request->nationalid),
                'homeaddress' => mb_strtoupper($request->homeaddress),
                'employmenttype' => $request->employmenttype,
                'employmentstatus' => $request->employmentstatus,
                'avatar' => $name ?? null,
                'created_by' => $current_user_id, // ID do usuário atual
                'created_at' => now()
            ];

            $person_id = DB::table('people')->insertGetId($peopleData);

            // Verifica se o registro foi criado corretamente
            $created_person = DB::table('people')
                ->where('id', $person_id)
                ->first();

            \Log::info('Pessoa criada:', (array)$created_person);

            if (!$created_person || $created_person->created_by != $current_user_id) {
                throw new \Exception('Falha ao salvar created_by');
            }

            // Insere dados da empresa
            table::companydata()->insert([
                'reference' => $person_id,
                'company' => mb_strtoupper($request->company),
                'department' => mb_strtoupper($request->department),
                'jobposition' => mb_strtoupper($request->jobtitle),
                'companyemail' => mb_strtolower($request->companyemail),
                'leaveprivilege' => $request->leaveprivilege,
                'idno' => mb_strtoupper($request->idno),
                'startdate' => date("Y-m-d", strtotime($request->startdate)),
                'dateregularized' => date("Y-m-d", strtotime($request->dateregularized)),
            ]);

            DB::commit();

            return redirect('admin/employee/add')
                ->with('success', trans("Successful registration")); 

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro:', ['error' => $e->getMessage()]);
            return redirect('admin/employee/add')->with('error', $e->getMessage());
        }
    }

    public function index() 
    {
        if (permission::permitted('employees')=='fail'){ return redirect()->route('denied'); }

        $user = auth()->user();
        
        // Se for super admin, vê tudo
        if ($user->role_id === 1) { // Ajuste esse ID conforme seu sistema
            $employees = table::people()
                ->join('company_data', 'people.id', '=', 'company_data.reference')
                ->get();
        } else {
            // Outros usuários só veem os registros que criaram
            $employees = table::people()
                ->join('company_data', 'people.id', '=', 'company_data.reference')
                ->where('people.created_by', $user->id)
                ->get();
        }
        
        return view('admin.employee', ['employees' => $employees]);
    }

    // Também modifique o método view
    public function view($id, Request $request)
    {
        if (permission::permitted('employee-view')=='fail'){ return redirect()->route('denied'); }

        $user = auth()->user();
        
        $employee = table::people()->where('id', $id)->first();
        
        // Verifica se o usuário tem permissão para ver este registro
        if (!$user->role_id === 1 && $employee->created_by !== $user->id) {
            return redirect()->route('denied');
        }

        $employee_data = table::companydata()->where('reference', $id)->first();
        $profile_photo = $employee->avatar;
        $leavetype = table::leavetypes()->get();
        $leavegroup = table::leavegroup()->get();

        return view('admin.employee-view', [
            'employee' => $employee,
            'employee_data' => $employee_data,
            'profile_photo' => $profile_photo,
            'leavetype' => $leavetype,
            'leavegroup' => $leavegroup
        ]);
    }
} 