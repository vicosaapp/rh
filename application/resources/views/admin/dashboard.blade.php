@extends('layouts.admin')

@section('meta')
    <title>Dashboard | Workday Time Clock</title>
    <meta name="description" content="Workday Dashboard">
@endsection

@section('content')
<div class="container mt-4">
    <!-- Row of Info Boxes -->
    <div class="row g-4">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="info-box shadow-sm rounded bg-white">
                <span class="info-box-icon bg-primary text-white d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-circle fa-2x"></i>
                </span>
                <div class="info-box-content">
                    <h5 class="info-box-text text-uppercase text-secondary">{{ __('Employees') }}</h5>
                    <div class="progress-group">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                        <div class="stats_d mt-2">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Regular') }}</td>
                                        <td class="text-end fw-bold">@isset($employee_regular) {{ $employee_regular }} @endisset</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Trainee') }}</td>
                                        <td class="text-end fw-bold">@isset($employee_trainee) {{ $employee_trainee }} @endisset</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Attendances Info Box -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="info-box shadow-sm rounded bg-white">
                <span class="info-box-icon bg-success text-white d-flex align-items-center justify-content-center">
                    <i class="fas fa-clock fa-2x"></i>
                </span>
                <div class="info-box-content">
                    <h5 class="info-box-text text-uppercase text-secondary">{{ __('Attendances') }}</h5>
                    <div class="progress-group">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                        <div class="stats_d mt-2">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Online') }}</td>
                                        <td class="text-end fw-bold">@isset($is_online_now) {{ $is_online_now }} @endisset</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Offline') }}</td>
                                        <td class="text-end fw-bold">@isset($is_offline_now) {{ $is_offline_now }} @endisset</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Leaves Info Box -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="info-box shadow-sm rounded bg-white">
                <span class="info-box-icon bg-warning text-white d-flex align-items-center justify-content-center">
                    <i class="fas fa-calendar-plus fa-2x"></i>
                </span>
                <div class="info-box-content">
                    <h5 class="info-box-text text-uppercase text-secondary">{{ __('Leaves of Absence') }}</h5>
                    <div class="progress-group">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 100%"></div>
                        </div>
                        <div class="stats_d mt-2">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Approved') }}</td>
                                        <td class="text-end fw-bold">@isset($employee_leaves_approved_count) {{ $employee_leaves_approved_count }} @endisset</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Pending') }}</td>
                                        <td class="text-end fw-bold">@isset($employee_leaves_pending_count) {{ $employee_leaves_pending_count }} @endisset</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Rows -->
    <div class="row g-4 mt-4">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">{{ __('Newest Employees') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th class="text-end">{{ __('Start Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($recent_employees)
                                @foreach ($recent_employees as $data)
                                <tr>
                                    <td>{{ $data->lastname }}, {{ $data->firstname }}</td>
                                    <td class="text-end">@php echo e(date('M d, Y', strtotime($data->startdate))) @endphp</td>
                                </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold">{{ __('Recent Attendances') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th class="text-end">{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($recent_attendance)
                                @foreach($recent_attendance as $v)
                                <tr>
                                    <td>{{ $v->employee }}</td>
                                    <td>{{ $v->timein && !$v->timeout ? 'Clock-In' : 'Clock-Out' }}</td>
                                    <td class="text-end">
                                        @php
                                            $time = $v->timein && !$v->timeout ? $v->timein : $v->timeout;
                                            echo e($time_format == 12 ? date('h:i:s A', strtotime($time)) : date('H:i:s', strtotime($time)));
                                        @endphp
                                    </td>
                                </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white fw-bold">{{ __('Recent Leaves of Absence') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th class="text-end">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($recent_leaves)
                                @foreach ($recent_leaves as $leaves)
                                <tr>
                                    <td>{{ $leaves->employee }}</td>
                                    <td class="text-end">@php echo e(date('M d, Y', strtotime($leaves->leavefrom))) @endphp</td>
                                </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
