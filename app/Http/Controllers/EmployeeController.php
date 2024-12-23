<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $query = Employee::with('creator');
        
        if (!auth()->user()->is_admin) {
            $query->where('created_by', auth()->id());
        }
        
        $employees = $query->get();
        
        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // ... suas validações ...
        ]);

        $validated['created_by'] = auth()->id();
        
        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Funcionário adicionado com sucesso.');
    }

    public function show(Employee $employee)
    {
        if (!auth()->user()->is_admin && $employee->created_by !== auth()->id()) {
            abort(403, 'Você não tem permissão para ver este funcionário.');
        }

        return view('employees.show', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        if (!auth()->user()->is_admin && $employee->created_by !== auth()->id()) {
            abort(403, 'Você não tem permissão para editar este funcionário.');
        }

        // ... resto do código de atualização ...
    }

    public function destroy(Employee $employee)
    {
        if (!auth()->user()->is_admin && $employee->created_by !== auth()->id()) {
            abort(403, 'Você não tem permissão para excluir este funcionário.');
        }

        // ... resto do código de exclusão ...
    }
} 