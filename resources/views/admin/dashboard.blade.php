@extends('admin.layout.index')
@section('title', 'Dashboard')

@section('content')
<div class="main-content app-content">
            <div class="container-fluid">


                <!-- Start::page-header -->
                <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
                    <div>
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);">
                                    Dashboards
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
                        </ol>
                        <h1 class="page-title fw-medium fs-18 mb-0">Main Dashboard</h1>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="btn-list">
                            <button class="btn btn-white btn-wave">
                                <i class="ri-filter-3-line align-middle me-1 lh-1"></i> Filter
                            </button>
                            <button class="btn btn-primary btn-wave me-0">
                                <i class="ri-share-forward-line me-1"></i> Share
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End::page-header -->

                <!-- Start:: row-1 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xxl-3 col-xl-6">
                                <div class="card custom-card overflow-hidden main-content-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted d-block mb-1">Total Events</span>
                                                <h4 class="fw-medium mb-0">123</h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                                    <i class="uil uil-schedule fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6">
                                <div class="card custom-card overflow-hidden main-content-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="d-block text-muted mb-1">Total Users</span>
                                                <h4 class="fw-medium mb-0">123</h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary1">
                                                    <i class="ti ti-users fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6">
                                <div class="card custom-card overflow-hidden main-content-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted d-block mb-1">Total Attendee</span>
                                                <h4 class="fw-medium mb-0">123</h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary2">
                                                    <i class="ti ti-currency-dollar fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6">
                                <div class="card custom-card overflow-hidden main-content-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                            <div>
                                                <span class="text-muted d-block mb-1">Total Gallery</span>
                                                <h4 class="fw-medium mb-0">23</h4>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary3">
                                                    <i class="ti ti-chart-bar fs-5"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:: row-1 -->
            </div>
        </div>
@endsection

@section('modals')
<div class="modal fade" id="successModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body text-center p-2">
					 <img src="{{asset('admin_assets/images/check.gif')}}" class="animatedIcons" style="height: 130px"  alt="Approve Action" >
					<div class="mt-2">
						<h4 class="mb-3">Attendence Marked Successfully</h4>
						<p class="text-muted mb-4">Attendee Marked as present successfully.</p>
						<div class="hstack gap-2 justify-content-center">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							{{-- <a href="javascript:void(0);" class="btn btn-danger">Confirm</a> --}}
						</div>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


<div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body text-center p-2">
					 <img src="{{asset('admin_assets/images/cancel.gif')}}" class="animatedIcons" style="height: 130px"  alt="Approve Action" >
					<div class="mt-2">
						<h4 class="mb-3">Something Went Wrong</h4>
						<p class="text-muted mb-4"><b>{{session('error')}}</b></p>
						<div class="hstack gap-2 justify-content-center">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							{{-- <a href="javascript:void(0);" class="btn btn-danger">Confirm</a> --}}
						</div>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection

@section('custom-js')
@if(session('success'))
<script>
    $(document).ready(function() {
        $('#successModal').modal('show');
    });
</script>
 @endif

 @if(session('error'))
<script>
    $(document).ready(function() {
        $('#errorModal').modal('show');
    });
</script>
 @endif
@endsection