@foreach($employees as $employee)
    @if(auth()->user()->is_admin || $employee->created_by === auth()->id())
    <tr>
        <td>{{ $employee->name }}</td>
        <!-- ... outras colunas ... -->
        <td>
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-primary">Editar</a>
            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
            </form>
        </td>
    </tr>
    @endif
@endforeach 