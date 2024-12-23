@extends('layouts.admin')

@section('meta')
    <title>Edit Leave Group | Workday Time Clock</title>
    <meta name="description" content="Workday Edit Leave Group">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <h2 class="page-title">
                        {{ __("Edit Leave Group") }}
                    </h2>
                </div>

                <div class="col-md-6 mb-1 text-end">
                    <a href="{{ url('/admin/leavegroups') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left"></i><span class="button-with-icon">{{ __("Return") }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="{{ url('admin/leavegroups/update') }}" method="post" class="needs-validation" autocomplete="off" novalidate accept-charset="utf-8">
            @csrf
            <div class="card-header"></div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="leavegroup" class="form-label">{{ __("Leave Group Name") }}</label>
                    <input type="text" name="leavegroup" value="@isset($leavegroups){{$leavegroups->leavegroup}}@endisset" class="form-control text-uppercase" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __("Description") }}</label>
                    <input type="text" name="description" value="@isset($leavegroups){{$leavegroups->description}}@endisset" class="form-control text-uppercase" required>
                </div>

                <div class="mb-3">
                    <label for="leaveprivileges" class="form-label">{{ __('Leave Privileges') }}</label>
                    @isset($leavetypes)
                    <div class="row">
                        @foreach($leavetypes as $leave)
                            <div class="col-md-6">
                                <div class="form-check">
                                  <input type="checkbox" name="leaveprivileges[]" value="{{ $leave->id }}" class="form-check-input" id="customCheck{{ $leave->id }}">
                                  <label class="form-check-label" for="customCheck{{ $leave->id }}">{{ $leave->leavetype }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endisset
                </div>
               
               <div class="mb-3">
                  <label for="status" class="form-label">{{ __("Status") }}</label>
                  <select name="status" class="form-select" required>
                    <option value="" disabled selected>Choose...</option>
                    <option value="1" @isset($leavegroups) @if($leavegroups->status == 1) selected @endif @endisset>{{ __("Active") }}</option>
                    <option value="0" @isset($leavegroups) @if($leavegroups->status == 0) selected @endif @endisset>{{ __("Disabled") }}</option>
                  </select>
                </div>
            </div>
            <div class="card-footer text-end">
                <input type="hidden" name="id" value="@isset($leavegroups){{$leavegroups->id}}@endisset">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i><span class="button-with-icon">{{ __("Save") }}</span>
                </button>

                <a href="{{ url('/admin/leavegroups') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i><span class="button-with-icon">{{ __("Cancel") }}</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('/assets/js/validate-form.js') }}"></script>
@endsection