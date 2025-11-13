@extends('admin.layout.index')
@section('title', 'Project Management')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project Management</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Manage Projects</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="ri-add-line align-bottom"></i> Add Project
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="{{ route('admin.projects') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by title, category, client, or location..." value="{{ $filter }}" name="filter">
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
                                        <th>Client</th>
                                        <th>Location</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projects as $project)
                                        <tr>
                                            <td>{{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->index + 1 }}</td>
                                            <td><img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>{{ $project->title }}</td>
                                            <td>{{ $project->category }}</td>
                                            <td>{{ $project->client_name ?? 'N/A' }}</td>
                                            <td>{{ $project->project_location ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $project->is_featured ? 'success' : 'secondary' }}">
                                                    {{ $project->is_featured ? 'Featured' : 'Regular' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $project->is_active ? 'success' : 'danger' }}">
                                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary editBtn"
                                                    data-id="{{ $project->id }}"
                                                    data-title="{{ $project->title }}"
                                                    data-description="{{ $project->description }}"
                                                    data-additional_content="{{ $project->additional_content }}"
                                                    data-conclusion="{{ $project->conclusion }}"
                                                    data-category="{{ $project->category }}"
                                                    data-client_name="{{ $project->client_name }}"
                                                    data-project_location="{{ $project->project_location }}"
                                                    data-project_date="{{ $project->project_date }}"
                                                    data-project_duration="{{ $project->project_duration }}"
                                                    data-project_value="{{ $project->project_value }}"
                                                    data-sort_order="{{ $project->sort_order }}"
                                                    data-is_featured="{{ $project->is_featured }}"
                                                    data-is_active="{{ $project->is_active }}"
                                                    data-featured_image_url="{{ $project->featured_image_url }}"
                                                    data-secondary_image_url="{{ $project->secondary_image_url }}"
                                                    data-features="{{ json_encode($project->features) }}"
                                                    data-progress_data="{{ json_encode($project->progress_data) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editProjectModal">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                                <button class="btn btn-icon rounded-pill btn-danger btn-wave shadow-danger deleteBtn"
                                                    data-id="{{ $project->id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No Projects Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $projects->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProjectForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" class="form-control" placeholder="Project Title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Haram Makkah Projects">Haram Makkah Projects</option>
                                    <option value="Major Shopping Malls">Major Shopping Malls</option>
                                    <option value="Universities & Hospitals">Universities & Hospitals</option>
                                    <option value="Commercial Buildings">Commercial Buildings</option>
                                    <option value="Industrial Projects">Industrial Projects</option>
                                    <option value="Power Plants">Power Plants</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Project Description" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Additional Content</label>
                                <textarea name="additional_content" class="form-control" rows="3" placeholder="Additional Project Details"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Project Features</label>
                                <div id="addFeaturesWrapper" class="features-wrapper"></div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addFeatureField">
                                    <i class="ri-add-line align-bottom"></i> Add Feature
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Conclusion</label>
                                <textarea name="conclusion" class="form-control" rows="3" placeholder="Project Conclusion"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Project Progress</label>
                                <div id="addProgressWrapper" class="progress-wrapper"></div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addProgressField">
                                    <i class="ri-add-line align-bottom"></i> Add Progress Item
                                </button>
                                <small class="text-muted d-block mt-1">Set progress percentages between 0 and 100.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Featured Image *</label>
                                <input type="file" name="featured_image" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Secondary Image</label>
                                <input type="file" name="secondary_image" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple>
                                <small class="text-muted">You can select multiple images</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="client_name" class="form-control" placeholder="Client Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Project Location</label>
                                <input type="text" name="project_location" class="form-control" placeholder="Project Location">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Date</label>
                                <input type="date" name="project_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Duration</label>
                                <input type="text" name="project_duration" class="form-control" placeholder="e.g., 6 months">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Value (SR)</label>
                                <input type="number" name="project_value" class="form-control" placeholder="0.00" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="addIsFeatured" name="is_featured">
                                    <label class="form-check-label" for="addIsFeatured">Featured Project</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="addIsActive" name="is_active" checked>
                                    <label class="form-check-label" for="addIsActive">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-wave shadow-primary">Add Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProjectForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="editProjectId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" name="title" id="editProjectTitle" class="form-control" placeholder="Project Title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category" id="editProjectCategory" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Haram Makkah Projects">Haram Makkah Projects</option>
                                    <option value="Major Shopping Malls">Major Shopping Malls</option>
                                    <option value="Universities & Hospitals">Universities & Hospitals</option>
                                    <option value="Commercial Buildings">Commercial Buildings</option>
                                    <option value="Industrial Projects">Industrial Projects</option>
                                    <option value="Power Plants">Power Plants</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea name="description" id="editProjectDescription" class="form-control" rows="4" placeholder="Project Description" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Additional Content</label>
                                <textarea name="additional_content" id="editProjectAdditionalContent" class="form-control" rows="3" placeholder="Additional Project Details"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Project Features</label>
                                <div id="editFeaturesWrapper" class="features-wrapper"></div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="editFeatureField">
                                    <i class="ri-add-line align-bottom"></i> Add Feature
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Conclusion</label>
                                <textarea name="conclusion" id="editProjectConclusion" class="form-control" rows="3" placeholder="Project Conclusion"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Project Progress</label>
                                <div id="editProgressWrapper" class="progress-wrapper"></div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="editProgressField">
                                    <i class="ri-add-line align-bottom"></i> Add Progress Item
                                </button>
                                <small class="text-muted d-block mt-1">Set progress percentages between 0 and 100.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Current Featured Image</label>
                                <div id="currentFeaturedImage"></div>
                                <label class="form-label mt-2">New Featured Image</label>
                                <input type="file" name="featured_image" class="form-control">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Current Secondary Image</label>
                                <div id="currentSecondaryImage"></div>
                                <label class="form-label mt-2">New Secondary Image</label>
                                <input type="file" name="secondary_image" class="form-control">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">New Gallery Images</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple>
                                <small class="text-muted">Select new images to replace existing gallery</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Client Name</label>
                                <input type="text" name="client_name" id="editProjectClientName" class="form-control" placeholder="Client Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Project Location</label>
                                <input type="text" name="project_location" id="editProjectLocation" class="form-control" placeholder="Project Location">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Date</label>
                                <input type="date" name="project_date" id="editProjectDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Duration</label>
                                <input type="text" name="project_duration" id="editProjectDuration" class="form-control" placeholder="e.g., 6 months">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Project Value (SR)</label>
                                <input type="number" name="project_value" id="editProjectValue" class="form-control" placeholder="0.00" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" id="editProjectSortOrder" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editIsFeatured" name="is_featured">
                                    <label class="form-check-label" for="editIsFeatured">Featured Project</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editIsActive" name="is_active">
                                    <label class="form-check-label" for="editIsActive">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill btn-wave shadow-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    function createFeatureField($wrapper, value = '') {
        var $group = $('<div class="input-group feature-item mb-2"></div>');
        var $input = $('<input type="text" name="features[]" class="form-control" placeholder="Enter project feature">').val(value);
        var $button = $('<button type="button" class="btn btn-outline-danger remove-feature-btn"><i class="ri-close-line"></i></button>');
        $group.append($input).append($button);
        $wrapper.append($group);
    }

    function createProgressField($wrapper, label = '', percentage = '') {
        var $row = $('<div class="row g-2 align-items-center progress-item mb-2"></div>');
        var $labelCol = $('<div class="col-md-6 col-12"></div>');
        var $labelInput = $('<input type="text" name="progress_labels[]" class="form-control" placeholder="Milestone label">').val(label);
        var $percentageCol = $('<div class="col-md-4 col-8"></div>');
        var $percentageInput = $('<input type="number" name="progress_percentages[]" class="form-control" placeholder="Percentage" min="0" max="100">').val(percentage);
        var $buttonCol = $('<div class="col-md-2 col-4"></div>');
        var $button = $('<button type="button" class="btn btn-outline-danger w-100 remove-progress-btn"><i class="ri-close-line"></i></button>');

        $labelCol.append($labelInput);
        $percentageCol.append($percentageInput);
        $buttonCol.append($button);
        $row.append($labelCol, $percentageCol, $buttonCol);
        $wrapper.append($row);
    }

    function ensureFeatureField($wrapper) {
        if ($wrapper.find('.feature-item').length === 0) {
            createFeatureField($wrapper);
        }
    }

    function ensureProgressField($wrapper) {
        if ($wrapper.find('.progress-item').length === 0) {
            createProgressField($wrapper);
        }
    }

    function populateFeatureFields($wrapper, items) {
        $wrapper.empty();

        if (!Array.isArray(items) && typeof items === 'object' && items !== null) {
            items = Object.values(items);
        }

        if (Array.isArray(items) && items.length > 0) {
            items.forEach(function(item) {
                if (item) {
                    createFeatureField($wrapper, item);
                }
            });
        }

        ensureFeatureField($wrapper);
    }

    function populateProgressFields($wrapper, items) {
        $wrapper.empty();

        if (!Array.isArray(items) && typeof items === 'object' && items !== null) {
            items = Object.values(items);
        }

        if (Array.isArray(items) && items.length > 0) {
            items.forEach(function(item) {
                if (item) {
                    var label = item.label || '';
                    var percentage = item.percentage !== undefined ? item.percentage : '';
                    createProgressField($wrapper, label, percentage);
                }
            });
        }

        ensureProgressField($wrapper);
    }

    ensureFeatureField($('#addFeaturesWrapper'));
    ensureProgressField($('#addProgressWrapper'));

    $('#addFeatureField').on('click', function() {
        createFeatureField($('#addFeaturesWrapper'));
    });

    $('#addProgressField').on('click', function() {
        createProgressField($('#addProgressWrapper'));
    });

    $('#editFeatureField').on('click', function() {
        createFeatureField($('#editFeaturesWrapper'));
    });

    $('#editProgressField').on('click', function() {
        createProgressField($('#editProgressWrapper'));
    });

    $(document).on('click', '.remove-feature-btn', function() {
        var $wrapper = $(this).closest('.features-wrapper');
        $(this).closest('.feature-item').remove();
        ensureFeatureField($wrapper);
    });

    $(document).on('click', '.remove-progress-btn', function() {
        var $wrapper = $(this).closest('.progress-wrapper');
        $(this).closest('.progress-item').remove();
        ensureProgressField($wrapper);
    });

    // Add Project Form Submission
    $('#addProjectForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('Adding...').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.projects.store') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#addProjectModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'Something went wrong. Please try again later.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                alert(errorMessage);
            },
            complete: function() {
                submitBtn.html('Add Project').prop('disabled', false);
            }
        });
    });

    // Edit Button Click
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');
        var additional_content = $(this).data('additional_content');
        var conclusion = $(this).data('conclusion');
        var category = $(this).data('category');
        var client_name = $(this).data('client_name');
        var project_location = $(this).data('project_location');
        var project_date = $(this).data('project_date');
        var project_duration = $(this).data('project_duration');
        var project_value = $(this).data('project_value');
        var sort_order = $(this).data('sort_order');
        var is_featured = $(this).data('is_featured');
        var is_active = $(this).data('is_active');
        var featured_image_url = $(this).data('featured_image_url');
        var secondary_image_url = $(this).data('secondary_image_url');
        var features = $(this).data('features') || [];
        var progress_data = $(this).data('progress_data') || [];

        $('#editProjectId').val(id);
        $('#editProjectTitle').val(title);
        $('#editProjectDescription').val(description);
        $('#editProjectAdditionalContent').val(additional_content);
        $('#editProjectConclusion').val(conclusion);
        $('#editProjectCategory').val(category);
        $('#editProjectClientName').val(client_name);
        $('#editProjectLocation').val(project_location);
        $('#editProjectDate').val(project_date);
        $('#editProjectDuration').val(project_duration);
        $('#editProjectValue').val(project_value);
        $('#editProjectSortOrder').val(sort_order);
        $('#editIsFeatured').prop('checked', is_featured);
        $('#editIsActive').prop('checked', is_active);
        
        $('#currentFeaturedImage').html('<img src="' + featured_image_url + '" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">');
        
        if (secondary_image_url) {
            $('#currentSecondaryImage').html('<img src="' + secondary_image_url + '" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">');
        } else {
            $('#currentSecondaryImage').html('<p class="text-muted">No secondary image</p>');
        }

        populateFeatureFields($('#editFeaturesWrapper'), features);
        populateProgressFields($('#editProgressWrapper'), progress_data);
    });

    // Edit Project Form Submission
    $('#editProjectForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editProjectId').val();
        var formData = new FormData(this);
        formData.append('_method', 'POST');
        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('Updating...').prop('disabled', true);

        $.ajax({
            url: "{{ url('admin/projects') }}/" + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#editProjectModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'Something went wrong. Please try again later.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                alert(errorMessage);
            },
            complete: function() {
                submitBtn.html('Update Project').prop('disabled', false);
            }
        });
    });

    // Delete Button Click
    $(document).on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this project?')) {
            $.ajax({
                url: "{{ url('admin/projects') }}/" + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Something went wrong. Please try again later.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    });
});
</script>
@endsection
