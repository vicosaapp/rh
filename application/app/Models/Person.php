namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people'; // Define a tabela associada

    protected $fillable = [
        'firstname',
        'lastname',
        'emailaddress',
        'employmentstatus',
        'user_id', // Referência ao usuário que adicionou a pessoa
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}