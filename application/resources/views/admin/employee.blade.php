@extends('layouts.admin')

@section('meta')
    <title>Employee | Workday Time Clock</title>
    <meta name="description" content="Workday Employee">
@endsection

@section('content')
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModallabel">{{ __("Confirmation") }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>{{ __("Are you sure you want to delete the record?") }}</p>
      </div>
      <div class="modal-footer">
        <a href="" type="button" class="btn btn-danger modal_URL"><i class="fas fa-check-circle"></i> {{ __("Continue") }}</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> {{ __("Cancel") }}</button>
      </div> 
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <h2 class="page-title">
                        {{ __("Employee") }}
                    </h2>
                </div>

                <div class="col-md-6 mb-1 text-end">
                    <a href="{{ url('/admin/employee/add') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i><span class="button-with-icon">{{ __("Add") }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
<!-- ... código anterior ... -->

<table width="100%" class="table datatables-table custom-table-ui" data-order='[[ 0, "desc" ]]'>
    <thead>
        <tr>
            <th>{{ __('ID') }}</th> 
            <th>{{ __('Employee') }}</th> 
            <th>{{ __('Company') }}</th>
            <th>{{ __('Department') }}</th>
            <th>{{ __('Position') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created By') }}</th> <!-- Nova coluna -->
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @isset($employees)
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->idno }}</td>
                <td>{{ $employee->lastname }}, {{ $employee->firstname }}</td>
                <td>{{ $employee->company }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->jobposition }}</td>
                <td><span class="text-uppercase">@if($employee->employmentstatus == 'Active') Active @else Archived @endif</span></td>
                <td>
                    @php
                        $creator = DB::table('users')
                            ->where('id', $employee->created_by)
                            ->first();
                    @endphp
                    {{ $creator ? $creator->name : 'N/A' }}
                </td>
                <td class="text-end">
                    <a href="{{ url('/admin/employee/view') }}/{{ $employee->reference }}" class="btn btn-outline-secondary btn-sm btn-rounded"><i class="fas fa-file-alt"></i></a>
                    <a href="{{ url('/admin/employee/edit') }}/{{ $employee->reference }}" class="btn btn-outline-secondary btn-sm btn-rounded"><i class="fas fa-pen"></i></a>
                    <a href="{{ url('/admin/employee/archive') }}/{{ $employee->reference }}" class="btn btn-outline-secondary btn-sm btn-rounded"><i class="fas fa-archive"></i></a>
                    <a href="#" data-url="{{ url('/admin/employee/delete') }}/{{ $employee->reference }}" class="btn btn-outline-secondary btn-sm btn-rounded btnDelete" data-bs-toggle="modal" data-bs-target="#confirmationModal"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
        @endisset
    </tbody>
</table>

<!-- ... resto do código ... -->
            <!-- <small class="text-muted">{{ __("Only 250 recent records will be displayed use Date range filter to get more records") }}</small> -->
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/js/initiate-datatables-with-search.js') }}"></script>
    <script src="{{ asset('assets/js/confirmationModal.js') }}"></script>
@endsection