@extends('admin.layout.index')
@section('title', 'Event Gallery - ' . $event->name)

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('events-view') }}">Events</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Event Gallery</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Event Gallery - {{ $event->name }}</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                    <i class="ri-add-line align-bottom"></i> Add Image/Video
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Gallery Items</h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" id="selectAllBtn" style="display: none;">
                                    <i class="ri-checkbox-line"></i> Select All
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="selectNoneBtn" style="display: none;">
                                    <i class="ri-checkbox-blank-line"></i> Select None
                                </button>
                                <button class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display: none;">
                                    <i class="ri-delete-bin-line"></i> Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @forelse($galleries as $gallery)
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    <div class="card custom-card h-100 gallery-item" data-id="{{ $gallery->id }}">
                                        <div class="card-body p-0 position-relative">
                                            <!-- Selection Checkbox -->
                                            <div class="position-absolute top-0 start-0 m-2">
                                                <div class="form-check">
                                                    <input class="form-check-input gallery-checkbox" type="checkbox" value="{{ $gallery->id }}" id="gallery_{{ $gallery->id }}">
                                                    <label class="form-check-label" for="gallery_{{ $gallery->id }}"></label>
                                                </div>
                                            </div>
                                            
                                            <div class="gallery-item-wrapper" style="height: 200px; overflow: hidden;">
                                                @if($gallery->attachment_type === 'image')
                                                    <img src="{{ asset('storage/' . $gallery->attachment) }}" class="card-img-top" alt="Gallery Image" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <video class="card-img-top" controls style="width: 100%; height: 100%; object-fit: cover;">
                                                        <source src="{{ asset('storage/' . $gallery->attachment) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">{{ $gallery->created_at->format('d M Y, h:i A') }}</small>
                                                    <button class="btn btn-danger btn-sm delete-gallery" data-id="{{ $gallery->id }}">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        No images or videos found in the gallery.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            {{ $galleries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Image/Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="addGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Image/Video</label>
                        <input type="file" name="attachment" class="form-control" required>
                        <small class="text-muted">Supported formats: JPG, PNG, GIF, MP4. Max size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addGalleryBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $('#addGalleryForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#addGalleryForm'), "{{ route('add-gallery-image') }}", $('#addGalleryBtn'), '',
                onRequestSuccess, $('#addGalleryModal'));
        }
    });

    // Handle checkbox selection
    $(document).on('change', '.gallery-checkbox', function() {
        updateBulkActionButtons();
    });

    // Select All functionality
    $('#selectAllBtn').on('click', function() {
        $('.gallery-checkbox').prop('checked', true);
        updateBulkActionButtons();
    });

    // Select None functionality
    $('#selectNoneBtn').on('click', function() {
        $('.gallery-checkbox').prop('checked', false);
        updateBulkActionButtons();
    });

    // Update bulk action buttons visibility
    function updateBulkActionButtons() {
        var checkedCount = $('.gallery-checkbox:checked').length;
        var totalCount = $('.gallery-checkbox').length;
        
        if (checkedCount > 0) {
            $('#selectAllBtn, #selectNoneBtn, #bulkDeleteBtn').show();
            $('#bulkDeleteBtn').text('Delete Selected (' + checkedCount + ')');
        } else {
            $('#selectAllBtn, #selectNoneBtn, #bulkDeleteBtn').hide();
        }
        
        // Update select all button text
        if (checkedCount === totalCount && totalCount > 0) {
            $('#selectAllBtn').text('Select None');
        } else {
            $('#selectAllBtn').text('Select All');
        }
    }

    // Bulk delete functionality
    $('#bulkDeleteBtn').on('click', function() {
        var selectedIds = $('.gallery-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            alert('Please select items to delete.');
            return;
        }
        
        if (confirm('Are you sure you want to delete ' + selectedIds.length + ' selected item(s)?')) {
            // Disable button and show loading state
            var button = $(this);
            button.prop('disabled', true);
            button.html('<i class="ri-loader-4-line"></i> Deleting...');
            
            $.ajax({
                url: "{{ route('bulk-delete-gallery-images') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: selectedIds
                },
                success: function(response) {
                    if (response.success) {
                        alertMessage(response.message, false);
                        window.location.reload();
                    } else {
                        alertMessage(response.message || 'Failed to delete items', true);
                        // Reset button state
                        button.prop('disabled', false);
                        button.html('<i class="ri-delete-bin-line"></i> Delete Selected');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alertMessage('Failed to delete items. Please try again.', true);
                    // Reset button state
                    button.prop('disabled', false);
                    button.html('<i class="ri-delete-bin-line"></i> Delete Selected');
                }
            });
        }
    });

    // Handle individual delete gallery image/video
    $(document).on('click', '.delete-gallery', function() {
        var button = $(this);
        var id = button.data('id');
        
        if (confirm('Are you sure you want to delete this item?')) {
            // Disable button and show loading state
            button.prop('disabled', true);
            button.html('Deleting....');
            
            $.ajax({
                url: "{{ route('delete-gallery-image', '') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        alertMessage(response.message, false);
                    } else {
                        alertMessage(response.message || 'Failed to delete item', true);
                    }
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alertMessage('Failed to delete item. Please try again.', true);
                    // Reset button state
                    button.prop('disabled', false);
                    button.html('<i class="ri-delete-bin-line"></i>');
                }
            });
        }
    });
</script>
@endsection 