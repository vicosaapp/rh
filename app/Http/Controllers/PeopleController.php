<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeopleController extends Controller
{
    public function index()
    {
        try {
            // Query simples que será automaticamente filtrada pelo modelo
            $people = Person::query()->get();

            Log::info('Listando pessoas', [
                'user_id' => auth()->id(),
                'count' => $people->count()
            ]);

            return view('people.index', compact('people'));

        } catch (\Exception $e) {
            Log::error('Erro ao listar pessoas: ' . $e->getMessage());
            return back()->with('error', 'Erro ao listar pessoas.');
        }
    }

    public function show(Person $person)
    {
        // Verifica se o usuário criou este registro
        if ($person->created_by != auth()->id()) {
            Log::warning('Tentativa de acesso não autorizado', [
                'user_id' => auth()->id(),
                'person_id' => $person->id
            ]);
            abort(403, 'Você não tem permissão para ver este registro.');
        }

        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        // Verifica se o usuário criou este registro
        if ($person->created_by != auth()->id()) {
            Log::warning('Tentativa de edição não autorizada', [
                'user_id' => auth()->id(),
                'person_id' => $person->id
            ]);
            abort(403, 'Você não tem permissão para editar este registro.');
        }

        return view('people.edit', compact('person'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Debug para ver os dados recebidos
            Log::info('Dados recebidos:', $request->all());

            $validated = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                // ... outras validações ...
            ]);

            // Força o created_by
            $validated['created_by'] = auth()->id();

            // Debug dos dados validados
            Log::info('Dados validados:', $validated);

            // Cria o registro usando create
            $person = new Person();
            $person->fill($validated);
            $person->created_by = auth()->id(); // Força novamente
            $person->save();

            // Debug do registro criado
            Log::info('Pessoa criada:', $person->toArray());

            DB::commit();

            return redirect()->route('people.index')
                ->with('success', 'Pessoa adicionada com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar pessoa:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Erro ao criar pessoa: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Person $person)
    {
        // Verifica se o usuário tem permissão para atualizar este registro
        if (auth()->user()->role_id != 1 && $person->created_by != auth()->id()) {
            Log::warning('Tentativa de atualização não autorizada', [
                'user_id' => auth()->id(),
                'person_id' => $person->id
            ]);
            abort(403, 'Você não tem permissão para atualizar este registro.');
        }

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                // ... outras validações ...
            ]);

            $person->update($validated);

            DB::commit();

            Log::info('Pessoa atualizada com sucesso', [
                'person_id' => $person->id,
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('people.index')
                ->with('success', 'Pessoa atualizada com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar pessoa: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar pessoa: ' . $e->getMessage());
        }
    }

    public function destroy(Person $person)
    {
        // Verifica se o usuário tem permissão para excluir este registro
        if (auth()->user()->role_id != 1 && $person->created_by != auth()->id()) {
            Log::warning('Tentativa de exclusão não autorizada', [
                'user_id' => auth()->id(),
                'person_id' => $person->id
            ]);
            abort(403, 'Você não tem permissão para excluir este registro.');
        }

        try {
            DB::beginTransaction();
            
            $person->delete();
            
            DB::commit();

            Log::info('Pessoa excluída com sucesso', [
                'person_id' => $person->id,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('people.index')
                ->with('success', 'Pessoa excluída com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir pessoa: ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir pessoa: ' . $e->getMessage());
        }
    }
} 