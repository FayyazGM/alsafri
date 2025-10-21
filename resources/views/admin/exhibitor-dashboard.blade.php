@extends('admin.layout.index')
@section('title', 'Exhibitor Dashboard')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Welcome, {{ $exhibitor->name }}</h1>
                <p class="text-muted">Exhibitor Dashboard</p>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <!-- Statistics Cards -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-2">
                                    <h6 class="mb-1 text-muted">Total Events</h6>
                                    <h4 class="mb-0">{{ $statistics['total_events'] }}</h4>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-2">
                                    <span class="avatar avatar-md avatar-rounded bg-primary-transparent">
                                        <i class="ri-calendar-event-line fs-18"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-2">
                                    <h6 class="mb-1 text-muted">University</h6>
                                    <h4 class="mb-0 fs-14">{{ $statistics['university'] }}</h4>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-2">
                                    <span class="avatar avatar-md avatar-rounded bg-success-transparent">
                                        <i class="ri-school-line fs-18"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-2">
                                    <h6 class="mb-1 text-muted">Country</h6>
                                    <h4 class="mb-0 fs-14">{{ $statistics['country'] }}</h4>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-2">
                                    <span class="avatar avatar-md avatar-rounded bg-info-transparent">
                                        <i class="ri-map-pin-line fs-18"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Upcoming Events -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5 class="mb-0">Upcoming Events</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($upcoming_events->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcoming_events as $event)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $event->name }}</h6>
                                                            <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info-transparent">
                                                        {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>{{ $event->location ?? 'TBA' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $event->event_type == 'physical' ? 'primary' : 'success' }}-transparent">
                                                        {{ ucfirst($event->event_type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ri-calendar-event-line fs-48 text-muted"></i>
                                </div>
                                <h5 class="text-muted">No upcoming events</h5>
                                <p class="text-muted">There are currently no upcoming events scheduled.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Exhibitor Information -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5 class="mb-0">Exhibitor Information</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name</label>
                                    <p class="text-muted mb-0">{{ $exhibitor->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <p class="text-muted mb-0">{{ $exhibitor->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <p class="text-muted mb-0">{{ $exhibitor->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">University</label>
                                    <p class="text-muted mb-0">{{ $exhibitor->university ?? 'Not specified' }}</p>
                                </div>
                            </div>
                            @if($exhibitor->address)
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Address</label>
                                        <p class="text-muted mb-0">{{ $exhibitor->address }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
