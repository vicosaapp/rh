@foreach($people as $person)
    <tr>
        <td>{{ $person->firstname }} {{ $person->lastname }}</td>
        <!-- ... outras colunas ... -->
        <td>
            @if($person->created_by == auth()->id())
                <a href="{{ route('people.edit', $person) }}" class="btn btn-sm btn-primary">Editar</a>
                <form action="{{ route('people.destroy', $person) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach 