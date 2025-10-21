@extends('admin.layout.index')
@section('title', 'Registration Form - ' . $event->name)

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
                    <li class="breadcrumb-item">
                        <a href="{{ route('events-view') }}">Events</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Registration Form</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Registration Form - {{ $event->name }}</h1>
            </div>
            <div>
                <button class="btn btn-secondary rounded-pill btn-wave shadow-primary me-2" id="saveSortOrderBtn">
                    <i class="ri-save-line align-bottom"></i> Save Sort Order
                </button>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                    <i class="ri-add-line align-bottom"></i> Add Field
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Label</th>
                                        <th>Type</th>
                                        <th>Required</th>
                                        <th>Options</th>
                                        <th>Sort Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($registrationForm) > 0)
                                        @foreach ($registrationForm as $index => $field)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $field['label'] }}</td>
                                                <td>{{ ucfirst($field['type']) }}</td>
                                                <td>
                                                    @if($field['required'])
                                                        <span class="badge bg-success">Yes</span>
                                                    @else
                                                        <span class="badge bg-danger">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($field['options']) && is_array($field['options']))
                                                        {{ implode(', ', $field['options']) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                                                                 <td>
                                                     <input type="number" class="form-control form-control-sm sort-order-input" 
                                                            data-index="{{ $index }}" 
                                                            value="{{ isset($field['sort_order']) ? $field['sort_order'] : $index }}" 
                                                            min="0" style="width: 80px;">
                                                 </td>
                                                <td>
                                                    @if($field['label'] != 'name' && $field['label'] != 'email' && $field['label'] != 'Phone Number')
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                                                                                 <button class="dropdown-item editField" data-index="{{ $index }}" 
                                                                         data-required="{{ $field['required'] ? 1 : 0 }}"
                                                                         data-sort-order="{{ isset($field['sort_order']) ? $field['sort_order'] : $index }}">
                                                                     <i class="ri-edit-line"></i> Edit
                                                                 </button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item deleteField" data-index="{{ $index }}">
                                                                    <i class="ri-delete-bin-line"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                                                                 <tr>
                                             <td colspan="7" class="text-center">No Fields Found</td>
                                         </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Add Field Modal -->
<div class="modal fade" id="addFieldModal" tabindex="-1" aria-labelledby="addFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="addFieldForm" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Field Label</label>
                        <input type="text" name="label" class="form-control" placeholder="Enter field label" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Field Type</label>
                        <select name="type" class="form-select" id="fieldTypeSelect" required>
                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="tel">Phone</option>
                            <option value="select">Select</option>
                        </select>
                    </div>
                    <div class="mb-3" id="selectOptionsContainer" style="display:none;">
                        <label class="form-label">Select Options</label>
                        <div id="selectOptionsList">
                            <div class="input-group mb-2 select-option-row">
                                <input type="text" name="options[]" class="form-control" placeholder="Option value">
                                <button type="button" class="btn btn-danger remove-option-btn" style="display:none;">&times;</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="addOptionBtn">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="required" id="requiredField" value="1">
                            <label class="form-check-label" for="requiredField">
                                Required Field
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addFieldBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Add Field</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Field Modal -->
<div class="modal fade" id="editFieldModal" tabindex="-1" aria-labelledby="editFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="editFieldForm" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="index" id="editFieldIndex">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Required Field</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="required" id="editRequiredField" value="1">
                            <label class="form-check-label" for="editRequiredField">
                                Required Field
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="editSortOrder" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editFieldBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Update Field</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $('#addFieldForm').validate({
        submitHandler: function() {
            'use strict';
            
            // Remove empty option inputs if field type is not select
            if ($('#fieldTypeSelect').val() !== 'select') {
                $('#selectOptionsContainer input[name="options[]"]').remove();
            }
            
            handleAjaxCall($('#addFieldForm'), "{{ route('add-registration-field') }}", $('#addFieldBtn'), '',
                onRequestSuccess, $('#addFieldModal'));
        }
    });

    // Show/hide select options input
    $(document).on('change', '#fieldTypeSelect', function() {
        if ($(this).val() === 'select') {
            $('#selectOptionsContainer').show();
            $('#selectOptionsContainer input[name="options[]"]').prop('required', true);
        } else {
            $('#selectOptionsContainer').hide();
            $('#selectOptionsContainer input[name="options[]"]').prop('required', false);
        }
    });

    // Add new option input
    $(document).on('click', '#addOptionBtn', function() {
        var optionRow = `<div class="input-group mb-2 select-option-row">
            <input type="text" name="options[]" class="form-control" placeholder="Option value" required>
            <button type="button" class="btn btn-danger remove-option-btn">&times;</button>
        </div>`;
        $('#selectOptionsList').append(optionRow);
        updateRemoveOptionButtons();
    });

    // Remove option input
    $(document).on('click', '.remove-option-btn', function() {
        $(this).closest('.select-option-row').remove();
        updateRemoveOptionButtons();
    });

    function updateRemoveOptionButtons() {
        var rows = $('#selectOptionsList .select-option-row');
        if (rows.length > 1) {
            rows.find('.remove-option-btn').show();
        } else {
            rows.find('.remove-option-btn').hide();
        }
    }

    // Initialize on modal show
    $('#addFieldModal').on('shown.bs.modal', function () {
        $('#fieldTypeSelect').trigger('change');
        updateRemoveOptionButtons();
    });

    // Handle delete field
    $(document).on('click', '.deleteField', function() {
        var index = $(this).data('index');
        if (confirm('Are you sure you want to delete this field?')) {
            $.ajax({
                url: "{{ route('delete-registration-field') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: '{{ $event->id }}',
                    index: index
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    // Handle edit field
    $(document).on('click', '.editField', function() {
        var index = $(this).data('index');
        var required = $(this).data('required');
        var sortOrder = $(this).data('sort-order');
        
        $('#editFieldIndex').val(index);
        $('#editRequiredField').prop('checked', required == 1);
        $('#editSortOrder').val(sortOrder);
        
        $('#editFieldModal').modal('show');
    });

    // Handle edit field form submission
    $('#editFieldForm').validate({
        rules: {
            sort_order: {
                required: true,
                min: 0
            }
        },
        messages: {
            sort_order: {
                required: 'Sort order is required',
                min: 'Sort order must be at least 0'
            }
        },
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#editFieldForm'), "{{ route('edit-registration-field') }}", $('#editFieldBtn'), '',
                onRequestSuccess, $('#editFieldModal'));
        }
    });

    // Handle save sort order button click
    $(document).on('click', '#saveSortOrderBtn', function() {
        var sortOrder = {};
        
        // Collect all sort orders
        $('.sort-order-input').each(function() {
            var index = $(this).data('index');
            var order = parseInt($(this).val());
            sortOrder[index] = order;
        });
        
        // Show loading state
        $('#saveSortOrderBtn').html('<i class="ri-loader-4-line align-bottom"></i> Saving...');
        $('#saveSortOrderBtn').prop('disabled', true);
        
        // Save to database
        $.ajax({
            url: "{{ route('update-registration-field-order') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                event_id: '{{ $event->id }}',
                sort_order: sortOrder
            },
            success: function(response) {
                if (response.success) {
                    // Show success message and reload page
                    alertMessage('Sort order saved successfully!', false);
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    toastr.error(response.message || 'Failed to save sort order');
                    $('#saveSortOrderBtn').html('<i class="ri-save-line align-bottom"></i> Save Sort Order');
                    $('#saveSortOrderBtn').prop('disabled', false);
                }
            },
            error: function() {
                toastr.error('Failed to save sort order. Please try again.');
                $('#saveSortOrderBtn').html('<i class="ri-save-line align-bottom"></i> Save Sort Order');
                $('#saveSortOrderBtn').prop('disabled', false);
            }
        });
    });
</script>
@endsection