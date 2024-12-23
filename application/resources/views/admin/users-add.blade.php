@extends('layouts.admin')

@section('meta')
    <title>{{ __("Add New User") }} | Workday Time Clock</title>
    <meta name="description" content="Workday Add New User">
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/vendor/select2-bootstrap-5/select2-bootstrap-5-theme.min.css') }}">
<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-color: #e5e7eb;
        padding: 0.5rem 0.75rem;
        height: auto;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        color: #4b5563;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="page-title">
                        {{ __("Add New User") }}
                    </h2>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ url('/admin/users') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i>
                        <span class="button-with-icon">{{ __("Return") }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ url('admin/users/register') }}" method="post" class="needs-validation" autocomplete="off" novalidate>
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __("Employee") }}</label>
                            <select name="name" class="form-select select-search" required>
                                <option value="" disabled selected>{{ __("Choose...") }}</option>
                                @isset($employees)
                                    @foreach ($employees as $data)
                                        <option value="{{ $data->lastname }}, {{ $data->firstname }}" 
                                                data-email="{{ $data->emailaddress }}"
                                                data-ref="{{ $data->id }}">
                                            {{ $data->lastname }}, {{ $data->firstname }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __("Email") }}</label>
                            <input type="email" name="email" class="form-control" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">{{ __("Account Type") }}</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="acc_type" id="acc_type1" value="1" required>
                                <label class="form-check-label" for="acc_type1">{{ __("Employee") }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="acc_type" id="acc_type2" value="2" required>
                                <label class="form-check-label" for="acc_type2">{{ __("Admin") }}</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role_id" class="form-label">{{ __("Role") }}</label>
                            <select name="role_id" class="form-select" required>
                                <option value="" disabled selected>{{ __("Choose...") }}</option>
                                @isset($roles)
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">{{ __("Status") }}</label>
                            <select name="status" class="form-select" required>
                                <option value="" disabled selected>{{ __("Choose...") }}</option>
                                <option value="1">{{ __("Enabled") }}</option>
                                <option value="0">{{ __("Disabled") }}</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label">{{ __("Password") }}</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">{{ __("Confirm Password") }}</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent text-end">
                <input type="hidden" name="ref" value="">
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i>
                    <span class="button-with-icon">{{ __("Save") }}</span>
                </button>

                <a href="{{ url('/admin/users') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times-circle"></i>
                    <span class="button-with-icon">{{ __("Cancel") }}</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('/assets/js/validate-form.js') }}"></script>
<script src="{{ asset('/assets/js/get-user-email.js') }}"></script>
<script src="{{ asset('/assets/vendor/select2/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.select-search').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>
@endsection