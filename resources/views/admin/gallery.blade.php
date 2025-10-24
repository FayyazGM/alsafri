@extends('admin.layout.index')
@section('title', 'Gallery Management')

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
                    <li class="breadcrumb-item active" aria-current="page">Gallery Management</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Gallery Management</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                    <i class="ri-add-line align-bottom"></i> Add Image
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="galleryList">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by title, category, or description..." value="{{ $filter }}" name="filter">
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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($images) > 0)
                                        @foreach ($images as $image)
                                            <tr>
                                                <td>{{ ($images->currentPage() - 1) * $images->perPage() + $loop->index + 1 }}</td>
                                                <td>
                                                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                                </td>
                                                <td>{{ $image->title }}</td>
                                                <td><span class="badge bg-primary">{{ ucfirst($image->category) }}</span></td>
                                                <td>{{ $image->sort_order }}</td>
                                                <td>
                                                    @if($image->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $image->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary editBtn"
                                                        data-id="{{ $image->id }}"
                                                        data-title="{{ $image->title }}"
                                                        data-description="{{ $image->description }}"
                                                        data-category="{{ $image->category }}"
                                                        data-sort_order="{{ $image->sort_order }}"
                                                        data-is_active="{{ $image->is_active }}"
                                                        data-image_url="{{ $image->image_url }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editGalleryModal"
                                                    >
                                                        <i class="ri-pencil-line"></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-icon rounded-pill btn-danger btn-wave shadow-danger deleteBtn"
                                                        data-id="{{ $image->id }}"
                                                        data-title="{{ $image->title }}"
                                                    >
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">No Gallery Images Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $images->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('modals')
<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="addGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Image Title" required>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Image Description" rows="3"></textarea>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="elevator">Elevator Cladding</option>
                            <option value="escalator">Escalator Cladding</option>
                            <option value="steel">Steel Structures</option>
                            <option value="water">Water Tanks</option>
                            <option value="custom">Custom Fabrication</option>
                            <option value="industrial">Industrial Projects</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" placeholder="0" min="0" value="0">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addGalleryBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Add Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Gallery Modal -->
<div class="modal fade" id="editGalleryModal" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="editGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="editGalleryId">
                <div class="modal-body row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editGalleryTitle" class="form-control" placeholder="Image Title" required>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editGalleryDescription" class="form-control" placeholder="Image Description" rows="3"></textarea>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category" id="editGalleryCategory" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="elevator">Elevator Cladding</option>
                            <option value="escalator">Escalator Cladding</option>
                            <option value="steel">Steel Structures</option>
                            <option value="water">Water Tanks</option>
                            <option value="custom">Custom Fabrication</option>
                            <option value="industrial">Industrial Projects</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="editGallerySortOrder" class="form-control" placeholder="0" min="0">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Current Image 
                            <a href="#" class="ms-2 view-current-image" target="_blank">(View Current Image)</a>
                        </label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editGalleryStatus">
                            <label class="form-check-label" for="editGalleryStatus">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editGalleryBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Update Image</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
// Handle edit button click to populate modal
$(document).on('click', '.editBtn', function() {
    var id = $(this).data('id');
    var title = $(this).data('title');
    var description = $(this).data('description');
    var category = $(this).data('category');
    var sortOrder = $(this).data('sort_order');
    var isActive = $(this).data('is_active');
    var imageUrl = $(this).data('image_url');
    
    $('#editGalleryId').val(id);
    $('#editGalleryTitle').val(title);
    $('#editGalleryDescription').val(description);
    $('#editGalleryCategory').val(category);
    $('#editGallerySortOrder').val(sortOrder);
    $('#editGalleryStatus').prop('checked', isActive == 1);
    
    // Set the image URL in the view current image link
    $('.view-current-image').attr('href', imageUrl).show();
});

// Handle delete button click
$(document).on('click', '.deleteBtn', function() {
    var id = $(this).data('id');
    var title = $(this).data('title');
    
    if (confirm('Are you sure you want to delete "' + title + '"?')) {
        $.ajax({
            url: '/admin/gallery/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error deleting image');
                }
            },
            error: function() {
                alert('Error deleting image');
            }
        });
    }
});

// Handle add form submission
$('#addGalleryForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    var submitBtn = $('#addGalleryBtn');
    var originalBtnText = submitBtn.html();
    
    submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
    submitBtn.prop('disabled', true);
    
    $.ajax({
        url: '/admin/gallery',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#addGalleryModal').modal('hide');
                location.reload();
            } else {
                alert('Error adding image');
            }
        },
        error: function() {
            alert('Error adding image');
        },
        complete: function() {
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
        }
    });
});

// Handle edit form submission
$('#editGalleryForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    var id = $('#editGalleryId').val();
    var submitBtn = $('#editGalleryBtn');
    var originalBtnText = submitBtn.html();
    
    submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Updating...');
    submitBtn.prop('disabled', true);
    
    $.ajax({
        url: '/admin/gallery/' + id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#editGalleryModal').modal('hide');
                location.reload();
            } else {
                alert('Error updating image');
            }
        },
        error: function() {
            alert('Error updating image');
        },
        complete: function() {
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
        }
    });
});
</script>
@endsection
