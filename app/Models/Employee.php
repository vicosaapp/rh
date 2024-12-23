protected $fillable = [
    // ... outros campos ...
    'created_by',
];

// Adicione também a relação com o usuário
public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
} 