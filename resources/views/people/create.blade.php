<form method="POST" action="{{ route('people.store') }}">
    @csrf
    
    <!-- Adicione este campo hidden -->
    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
    
    <!-- ... resto do seu formulário ... -->
</form> 