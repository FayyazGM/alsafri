@extends('admin.layout.index')
@section('title', 'Media Management')

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
                    <li class="breadcrumb-item active" aria-current="page">Media Management</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Media Management</h1>
            </div>
            <div>
                <a href="{{ route('admin.media.create') }}" class="btn btn-primary rounded-pill btn-wave shadow-primary">
                    <i class="ri-add-line align-bottom"></i> Upload Media
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="mediaList">
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-bordered nowrap table-striped align-middle" style="width:100%;min-height:200px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Event</th>
                                        <th>Type</th>
                                        <th>File</th>
                                        <th>Size</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($media) > 0)
                                        @foreach ($media as $item)
                                            <tr>
                                                <td>{{ ($media->currentPage() - 1) * $media->perPage() + $loop->index + 1 }}</td>
                                                <td>
                                                    {{ $item->title ?: 'Untitled' }}
                                                    @if($item->description)
                                                        <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $item->event->name }}</td>
                                                <td>
                                                    @if($item->media_type === 'video')
                                                        <span class="badge bg-danger">Video</span>
                                                    @elseif($item->media_type === 'brochure')
                                                        <span class="badge bg-info">Brochure</span>
                                                    @else
                                                        <span class="badge bg-secondary">File</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->isVideo())
                                                            <i class="ri-video-line me-2 text-danger"></i>
                                                        @elseif($item->isBrochure())
                                                            <i class="ri-file-pdf-line me-2 text-info"></i>
                                                        @else
                                                            <i class="ri-file-line me-2 text-secondary"></i>
                                                        @endif
                                                        <span>{{ $item->file_name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $item->file_size_human }}</td>
                                                <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a href="{{ $item->file_url }}" target="_blank" class="dropdown-item">
                                                                    <i class="ri-eye-line"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('admin.media.show', $item->id) }}" class="dropdown-item">
                                                                    <i class="ri-information-line"></i> Details
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('admin.media.edit', $item->id) }}" class="dropdown-item">
                                                                    <i class="ri-pencil-line"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger deleteMediaBtn" data-id="{{ $item->id }}">
                                                                    <i class="ri-delete-bin-line"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">No media files found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $media->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    // Handle delete media
    $(document).on('click', '.deleteMediaBtn', function() {
        var mediaId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this media file? This action cannot be undone.')) {
            $.ajax({
                url: '/admin/media/' + mediaId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alertMessage(response.message, false);
                        location.reload();
                    } else {
                        alertMessage(response.message, true);
                    }
                },
                error: function() {
                    alertMessage('Error deleting media file', true);
                }
            });
        }
    });
});
</script>
@endsection
