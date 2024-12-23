<form action="{{ url('admin/employee/store') }}" method="post" class="needs-validation" autocomplete="off" novalidate enctype="multipart/form-data" accept-charset="utf-8">
    @csrf
    <input type="hidden" name="created_by" value="{{ auth()->id() }}">
    <!-- ... resto do formulário ... -->
</form> 