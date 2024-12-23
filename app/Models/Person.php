<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = [
        'user_id',
        'firstname',
        'mi',
        'lastname',
        'age',
        'gender',
        'emailaddress',
        'civilstatus',
        'height',
        'weight',
        'mobileno',
        'birthday',
        'nationalid',
        'birthplace',
        'homeaddress',
        'employmentstatus',
        'employmenttype',
        'avatar',
        'created_by',
    ];

    // Força o escopo global em todas as queries
    protected static function booted()
    {
        parent::booted();

        // Escopo global que SEMPRE filtra por created_by
        static::addGlobalScope('force_created_by', function (Builder $builder) {
            // Força o where mesmo que seja admin
            $builder->where('created_by', auth()->id());
        });

        // Garante que created_by seja sempre preenchido
        static::creating(function ($model) {
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
            
            Log::info('Criando funcionário:', [
                'user_id' => auth()->id(),
                'data' => $model->toArray()
            ]);
        });

        // Verifica se o registro foi salvo corretamente
        static::created(function ($model) {
            Log::info('Funcionário criado:', [
                'id' => $model->id,
                'created_by' => $model->created_by
            ]);
        });
    }

    // Sobrescreve o método newQuery para garantir que o filtro seja sempre aplicado
    public function newQuery()
    {
        $query = parent::newQuery();
        
        if (auth()->check()) {
            $query->where('created_by', auth()->id());
        }
        
        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 