<?php

namespace App\Http\Controllers\admin;

use DB;
use App\Classes\Table;
use App\Classes\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;


class UserController extends Controller
{
    public function index()
    {
        if (permission::permitted('users')=='fail'){ return redirect()->route('denied'); }
    
        $user = auth()->user();
        
        // Se for super admin (role_id = 1), vê todos os registros
        if ($user->role_id === 1) {
            $users_roles = table::users()
                ->join('users_roles', 'users.role_id', '=', 'users_roles.id')
                ->select('users.*', 'users_roles.role_name')
                ->get();
        } else {
            // Outros usuários só veem os registros que criaram
            $users_roles = table::users()
                ->join('users_roles', 'users.role_id', '=', 'users_roles.id')
                ->select('users.*', 'users_roles.role_name')
                ->where('users.created_by', $user->id)
                ->get();
        }
    
        $users = table::users()->get();
        $roles = table::roles()->get();
        $employees = table::people()->get();
    
        return view('admin.users', [
            'users' => $users,
            'roles' => $roles,
            'employees' => $employees, 
            'users_roles' => $users_roles
        ]);
    }

    public function add()
    {
        if (permission::permitted('user-add')=='fail'){ return redirect()->route('denied'); }

        $employees = table::people()->where('employmentstatus', 'Active')->get();
        $roles = table::roles()->get();
        
        return view('admin.users-add', [
            'employees' => $employees,
            'roles' => $roles
        ]);
    }

    public function register(Request $request)
    {
        if (permission::permitted('user-add')=='fail'){ return redirect()->route('denied'); } 
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required',
            'acc_type' => 'required',
            'status' => 'required',
            'ref' => 'required'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'acc_type' => $request->acc_type,
            'status' => $request->status,
            'reference' => $request->ref,
            'created_by' => auth()->id() // Adiciona o created_by
        ]);
    
        return redirect('admin/users')->with('success', trans('User registered successfully'));
    }

    public function edit($id) 
    {
        if (permission::permitted('user-edit')=='fail'){ return redirect()->route('denied'); }

        $roles = table::roles()->get();
        
        $user = table::users()->where('id', $id)->first();

        return view('admin.users-edit', [
            'roles' => $roles,
            'user' => $user, 
        ]);
    }

    public function update(Request $request) 
    {
        if (permission::permitted('user-edit')=='fail'){ return redirect()->route('denied'); }

        $v = $request->validate([
            'ref' => 'required|max:200',
            'role_id' => 'required|digits_between:1,99|max:2',
            'acc_type' => 'required|digits_between:1,99|max:2',
            'status' => 'required|boolean|max:1',
        ]);

        $ref = $request->ref;
		$role_id = $request->role_id;
		$acc_type = $request->acc_type;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $status = $request->status;

        if ($password !== null && $password_confirmation !== null) 
        {
            $v = $request->validate([
                'password' => 'required|min:8|max:100',
                'password_confirmation' => 'required|min:8|max:100',
            ]);

            if ($password != $password_confirmation) 
            {
                return redirect('admin/users')->with('error', trans("The passwords must match"));
            }

            table::users()->where('id', $ref)->update([
                'role_id' => $role_id,
                'acc_type' => $acc_type,
                'status' => $status,
                'password' => Hash::make($password),
            ]);
            
        } else {
            table::users()->where('id', $ref)->update([
                'role_id' => $role_id,
                'acc_type' => $acc_type,
                'status' => $status,
            ]);
        }

    	return redirect('admin/users')->with('success', trans("Update was successful"));       
    }

    public function delete($id, Request $request)
    {
        if (permission::permitted('user-delete')=='fail'){ return redirect()->route('denied'); }

    	table::users()->where('id', $id)->delete();
    	
        return redirect('admin/users')->with('success', trans("A user account is successfully deleted"));
    }
}
