<?php

namespace App\Http\Controllers\Admin;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeopleController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Log para debug
            Log::info('Criando nova pessoa', [
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                // ... outras validações
            ]);

            // Força o created_by
            $validated['created_by'] = auth()->id();

            // Cria a pessoa
            $person = Person::create($validated);

            // Log após criar
            Log::info('Pessoa criada', [
                'person_id' => $person->id,
                'created_by' => $person->created_by
            ]);

            DB::commit();

            return redirect()->route('admin.people.index')
                ->with('success', 'Pessoa adicionada com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar pessoa', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Erro ao criar pessoa: ' . $e->getMessage());
        }
    }
} 