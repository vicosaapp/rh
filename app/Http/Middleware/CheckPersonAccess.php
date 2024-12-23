<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Person;

class CheckPersonAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Se for uma listagem (index), modifica a query para filtrar
        if ($request->route()->getName() === 'people.index') {
            // Intercepta a query e força o filtro por created_by
            $people = Person::where('created_by', auth()->id())->get();
            
            // Substitui a collection original pela filtrada
            $request->merge(['filtered_people' => $people]);
            
            Log::info('Filtrando listagem de pessoas', [
                'user_id' => auth()->id(),
                'count' => $people->count()
            ]);
        }
        
        // Para outras ações (show, edit, update, delete)
        $person = $request->route('person');
        if ($person) {
            if ($person->created_by !== auth()->id()) {
                Log::warning('Acesso negado: tentativa de acessar registro de outro usuário', [
                    'user_id' => auth()->id(),
                    'person_id' => $person->id,
                    'created_by' => $person->created_by
                ]);
                
                abort(403, 'Você não tem permissão para acessar este registro.');
            }
        }

        return $next($request);
    }
} 