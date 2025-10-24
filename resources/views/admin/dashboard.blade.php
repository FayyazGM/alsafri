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
                                    Admin Panel
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                        <h1 class="page-title fw-medium fs-18 mb-0">Alsafri Admin Dashboard</h1>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="btn-list">
                            <a href="{{ route('admin.projects') }}" class="btn btn-white btn-wave">
                                <i class="ri-building-line align-middle me-1 lh-1"></i> Manage Projects
                            </a>
                            <a href="{{ route('admin.gallery') }}" class="btn btn-primary btn-wave me-0">
                                <i class="ri-image-line me-1"></i> Manage Gallery
                            </a>
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
                                                <span class="text-muted d-block mb-1">Total Projects</span>
                                                <h4 class="fw-medium mb-0">{{ $statistics['total_projects'] }}</h4>
                                                <small class="text-success">{{ $statistics['active_projects'] }} Active</small>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                                    <i class="ti ti-building fs-5"></i>
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
                                                <span class="d-block text-muted mb-1">Gallery Images</span>
                                                <h4 class="fw-medium mb-0">{{ $statistics['total_gallery_images'] }}</h4>
                                                <small class="text-success">{{ $statistics['active_gallery_images'] }} Active</small>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary1">
                                                    <i class="ti ti-photo fs-5"></i>
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
                                                <span class="text-muted d-block mb-1">Contact Messages</span>
                                                <h4 class="fw-medium mb-0">{{ $statistics['total_contact_messages'] }}</h4>
                                                <small class="text-info">{{ $statistics['recent_contact_messages'] }} This Week</small>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary2">
                                                    <i class="ti ti-message-circle fs-5"></i>
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
                                                <span class="text-muted d-block mb-1">Email Subscriptions</span>
                                                <h4 class="fw-medium mb-0">{{ $statistics['total_email_subscriptions'] }}</h4>
                                                <small class="text-warning">{{ $statistics['recent_subscriptions'] }} This Week</small>
                                            </div>
                                            <div class="lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary3">
                                                    <i class="ti ti-mail fs-5"></i>
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

                <!-- Start:: row-2 -->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Recent Contact Messages</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recent_messages as $message)
                                                <tr>
                                                    <td>{{ $message->name }}</td>
                                                    <td>{{ $message->email }}</td>
                                                    <td>{{ $message->subject ?? 'N/A' }}</td>
                                                    <td>{{ $message->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No recent messages</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Project Categories</div>
                            </div>
                            <div class="card-body">
                                @forelse($project_categories as $category)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span>{{ $category->category }}</span>
                                        <span class="badge bg-primary">{{ $category->count }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted">No project categories</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:: row-2 -->

                <!-- Start:: row-3 -->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Recent Projects</div>
                            </div>
                            <div class="card-body">
                                @forelse($recent_projects as $project)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            @if($project->featured_image_url)
                                                <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="ti ti-building text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $project->title }}</h6>
                                            <small class="text-muted">{{ $project->category }} • {{ $project->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $project->is_active ? 'success' : 'danger' }}">
                                                {{ $project->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No recent projects</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Recent Email Subscriptions</div>
                            </div>
                            <div class="card-body">
                                @forelse($recent_subscriptions as $subscription)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="ti ti-mail text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $subscription->email }}</h6>
                                            <small class="text-muted">{{ $subscription->subscribed_at->format('M d, Y H:i') }}</small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No recent subscriptions</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:: row-3 -->
            </div>
        </div>
@endsection

@section('modals')
<div class="modal fade" id="successModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body text-center p-2">
					 <img src="{{asset('admin_assets/images/check.gif')}}" class="animatedIcons" style="height: 130px"  alt="Success Action" >
					<div class="mt-2">
						<h4 class="mb-3">Action Completed Successfully</h4>
						<p class="text-muted mb-4">Your action has been completed successfully.</p>
						<div class="hstack gap-2 justify-content-center">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
					 <img src="{{asset('admin_assets/images/cancel.gif')}}" class="animatedIcons" style="height: 130px"  alt="Error Action" >
					<div class="mt-2">
						<h4 class="mb-3">Something Went Wrong</h4>
						<p class="text-muted mb-4"><b>{{session('error')}}</b></p>
						<div class="hstack gap-2 justify-content-center">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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