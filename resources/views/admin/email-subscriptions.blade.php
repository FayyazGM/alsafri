@extends('admin.layout.index')
@section('title', 'Email Subscriptions')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Email Subscriptions</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Email Subscriptions</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="emailSubscriptionsList">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by email or IP address..." value="{{ $filter }}" name="filter">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" class="btn btn-primary btn-wave w-100">
                                        <i class="ri-equalizer-fill me-2 align-bottom"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Email</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($subscriptions) > 0)
                                        @foreach ($subscriptions as $subscription)
                                            <tr>
                                                <td>{{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + $loop->index + 1 }}</td>
                                                <td>{{ $subscription->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ $subscription->email }}</td>
                                                <td>{{ $subscription->ip_address ?? 'N/A' }}</td>
                                                <td>
                                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $subscription->user_agent }}">
                                                        {{ $subscription->user_agent ?? 'N/A' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No Email Subscriptions Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $subscriptions->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
