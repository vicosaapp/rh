<?php

namespace App\Http\Controllers\admin;

use DB;
use App\Classes\Table;
use App\Classes\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{


	public function add() 
	{
		if (permission::permitted('employee-add')=='fail'){ return redirect()->route('denied'); }

		$employee = table::people()->get();
		$company = table::company()->get();
		$department = table::department()->get();
		$jobtitle = table::jobtitle()->get();
		$leavegroup = table::leavegroup()->get();

	    return view('admin.employee-add', [
	    	'employees' => $employee,
	    	'company' => $company,
	    	'department' => $department,
	    	'jobtitle' => $jobtitle,
	    	'leavegroup' => $leavegroup
	    ]);
	}

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
	
			// Prepara os dados para inserção
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
				'avatar' => $name,
				'created_by' => $current_user_id,
				'created_at' => now()
			];
	
			// Insere na tabela people
			$person_id = DB::table('people')->insertGetId($peopleData);
	
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
	
			return redirect('admin/employee/add')->with('success', trans("Successful registration")); 
	
		} catch (\Exception $e) {
			DB::rollBack();
			\Log::error('Erro ao criar funcionário:', [
				'error' => $e->getMessage(),
				'trace' => $e->getTraceAsString()
			]);
			return redirect('admin/employee/add')->with('error', $e->getMessage());
		}
	}
	
	public function index() 
	{
		if (permission::permitted('employees')=='fail'){ return redirect()->route('denied'); }
	
		$user = auth()->user();
		
		// Se for super admin, vê tudo
		if ($user->role_id === 1) {
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


	public function edit($id, Request $request)
    {
    	if (permission::permitted('employee-edit')=='fail'){ return redirect()->route('denied'); }

		$employee = table::people()->where('id', $id)->first();
		$employee_data = table::companydata()->where('id', $id)->first();
		$company = table::company()->get();
		$department = table::department()->get();
		$jobtitle = table::jobtitle()->get();
		$leavegroup = table::leavegroup()->get();

        return view('admin.employee-edit', [
	    	'employee' => $employee,
	    	'employee_data' => $employee_data,
	    	'company' => $company,
	    	'department' => $department,
	    	'jobtitle' => $jobtitle,
	    	'leavegroup' => $leavegroup
	    ]);
    }

    public function update(Request $request)
    {
    	if (permission::permitted('employee-edit')=='fail'){ return redirect()->route('denied'); }

		$v = $request->validate([
			'id' => 'required|max:200',
			'lastname' => 'required|max:155',
			'lastname' => 'required|max:155',
			'firstname' => 'required|max:155',
			'mi' => 'nullable|max:155',
			'age' => 'nullable|digits_between:0,199|max:3',
			'gender' => 'nullable|alpha|max:155',
			'emailaddress' => 'required|email|max:155',
			'civilstatus' => 'nullable|alpha|max:155',
			'mobileno' => 'nullable|max:155',
			'birthday' => 'nullable|date|max:155',
			'nationalid' => 'nullable|max:155',
			'birthplace' => 'nullable|max:255',
			'homeaddress' => 'nullable|max:255',
			'company' => 'nullable|max:100',
			'department' => 'nullable|max:100',
			'jobtitle' => 'nullable|max:100',
			'companyemail' => 'nullable|email|max:155',
			'leaveprivilege' => 'nullable|max:155',
			'idno' => 'required|max:155',
			'employmenttype' => 'required|max:155',
			'employmentstatus' => 'required|max:155',
			'startdate' => 'nullable|date|max:155',
			'dateregularized' => 'nullable|date|max:155'
		]);
	  
	  	$id = $request->id;
		$lastname = mb_strtoupper($request->lastname);
		$firstname = mb_strtoupper($request->firstname);
		$mi = mb_strtoupper($request->mi);
		$age = $request->age;
		$gender = mb_strtoupper($request->gender);
		$emailaddress = mb_strtolower($request->emailaddress);
		$civilstatus = mb_strtoupper($request->civilstatus);
		$mobileno = $request->mobileno;
		$birthday = date("Y-m-d", strtotime($request->birthday));
		$nationalid = mb_strtoupper($request->nationalid);
		$birthplace = mb_strtoupper($request->birthplace);
		$homeaddress = mb_strtoupper($request->homeaddress);
		$company = mb_strtoupper($request->company);
		$department = mb_strtoupper($request->department);
		$jobtitle = mb_strtoupper($request->jobtitle);
		$companyemail = mb_strtolower($request->companyemail);
		$leaveprivilege = $request->leaveprivilege;
		$idno = mb_strtoupper($request->idno);
		$employmenttype = $request->employmenttype;
		$employmentstatus = $request->employmentstatus;
		$startdate = date("Y-m-d", strtotime($request->startdate));
		$dateregularized = date("Y-m-d", strtotime($request->dateregularized));

		$file = $request->file('image');
		$name = null;

		if($file != null) 
		{
			$name = $request->file('image')->getClientOriginalName();
			
			$destinationPath = public_path() . '/assets/faces/';
			
			$file->move($destinationPath, $name);
			
		} else {
			$name = null;
		}
		
    	table::people()->where('id', $id)->update([
			'lastname' => $lastname,
			'firstname' => $firstname,
			'mi' => $mi,
			'age' => $age,
			'gender' => $gender,
			'emailaddress' => $emailaddress,
			'civilstatus' => $civilstatus,
			'mobileno' => $mobileno,
			'birthday' => $birthday,
			'birthplace' => $birthplace,
			'nationalid' => $nationalid,
			'homeaddress' => $homeaddress,
			'employmenttype' => $employmenttype,
			'employmentstatus' => $employmentstatus,
			'avatar' => $name,
    	]);

		table::companydata()->where('reference', $id)->update([
			'company' => $company,
			'department' => $department,
			'jobposition' => $jobtitle,
			'companyemail' => $companyemail,
			'leaveprivilege' => $leaveprivilege,
			'idno' => $idno,
			'startdate' => $startdate,
			'dateregularized' => $dateregularized,
    	]);

    	return redirect('admin/employee')->with('success', trans("Update was successful"));
    }

   	public function archive($id, Request $request)
    {
    	if (permission::permitted('employee-archive')=='fail'){ return redirect()->route('denied'); }

		$id = $request->id;

		table::people()->where('id', $id)->update(['employmentstatus' => 'Archived']);

		table::users()->where('reference', $id)->update(['status' => '0']);

    	return redirect('admin/employee')->with('success', trans("The employee is successfully archived"));
   	}

	public function delete(Request $request) 
	{
		if (permission::permitted('employee-delete')=='fail'){ return redirect()->route('denied'); }

		$id = $request->id;

		table::people()->where('id', $id)->delete();
		
		table::companydata()->where('reference', $id)->delete();
		
		table::attendance()->where('reference', $id)->delete();
		
		table::schedules()->where('reference', $id)->delete();
		
		table::leaves()->where('reference', $id)->delete();
		
		table::users()->where('reference', $id)->delete();

		return redirect('admin/employee')->with('success', trans("The employee is successfully removed"));
	}

}
