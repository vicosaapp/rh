namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        // Obtém as pessoas do usuário autenticado
        $people = auth()->user()->people;

        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'emailaddress' => 'required|email|max:255',
            // Adicione outras validações conforme necessário
        ]);

        // Cria uma nova pessoa associada ao usuário autenticado
        $person = new Person();
        $person->firstname = $request->firstname;
        $person->lastname = $request->lastname;
        $person->emailaddress = $request->emailaddress;
        $person->user_id = auth()->id(); // Associa a pessoa ao usuário autenticado
        $person->save();

        return redirect()->route('people.index')->with('success', 'Pessoa adicionada com sucesso!');
    }
}