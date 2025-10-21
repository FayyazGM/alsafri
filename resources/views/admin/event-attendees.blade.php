@extends('admin.layout.index')
@section('title', 'Event Attendees - ' . $event->name)

@php
use Illuminate\Support\Str;
@endphp

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
                    <li class="breadcrumb-item active" aria-current="page">Event Attendees</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Event Attendees - {{ $event->name }}</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="attendeeList">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by name or email..." value="{{ $filter }}" name="filter">
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
                    
                    <!-- Bulk Action Bar -->
                    <div class="card-body border-bottom-dashed border-bottom" id="bulkActionBar" style="display: none;">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span class="text-muted">
                                    <span id="selectedCount">0</span> attendee(s) selected
                                    <span id="selectionInfo" class="text-info ms-2"></span>
                                </span>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-success btn-sm me-2" id="bulkApproveBtn">
                                    <i class="ri-check-double-line me-1"></i> Approve Selected
                                </button>
                                <button type="button" class="btn btn-danger btn-sm me-2" id="bulkRejectBtn">
                                    <i class="ri-close-circle-line me-1"></i> Reject Selected
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" id="clearSelectionBtn">
                                    <i class="ri-close-line me-1"></i> Clear Selection
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-bordered nowrap  align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                                <label class="form-check-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Registration Date</th>
                                        <th>Additional Fields</th>
                                        <th>Preferred Universities</th>
                                        <th>Timeslot</th>
                                        <th>Approval Status</th>
                                        <th>Marked By</th>
                                        <th>Visited At</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($attendees) > 0)
                                        @foreach ($attendees as $attendee)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input attendee-checkbox" type="checkbox" 
                                                               value="{{ $attendee->id }}" 
                                                               data-status="{{ $attendee->is_approved }}"
                                                               @if($attendee->is_approved != 0) disabled @endif>
                                                    </div>
                                                </td>
                                                <td>{{ ($attendees->currentPage() - 1) * $attendees->perPage() + $loop->index + 1 }}</td>
                                                <td>{{ $attendee->name }}</td>
                                                <td>{{ $attendee->email }}</td>
                                                <td>{{ $attendee->phone_number }}</td>
                                                <td>{{ $attendee->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    @php
                                                        $otherFields = json_decode($attendee->other_fields, true);
                                                    @endphp
                                                    @if($otherFields && count($otherFields) > 0)
                                                        <button type="button" 
                                                                class="btn btn-outline-info btn-sm view-additional-fields" 
                                                                data-attendee-id="{{ $attendee->id }}"
                                                                data-fields="{{ json_encode($otherFields) }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#additionalFieldsModal">
                                                            <i class="ri-eye-line me-1"></i> ({{ count($otherFields) }})
                                                        </button>
                                                    @else
                                                        <span class="text-muted">No additional fields</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($attendee->universities)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach(json_decode($attendee->universities, true) as $university)
                                                                <li><span class="badge bg-warning"> {{ $university }} </span> </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($attendee->timeslot_from && $attendee->timeslot_to)
                                                        <span class="badge bg-info">
                                                            {{ \Carbon\Carbon::parse($attendee->timeslot_from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($attendee->timeslot_to)->format('h:i A') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($attendee->is_approved == 1)
                                                        @if($attendee->auto_approved)
                                                            <span class="badge bg-success">Auto-Approved</span>
                                                        @else
                                                            <span class="badge bg-success">Approved</span>
                                                        @endif
                                                    @elseif($attendee->is_approved == 2)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $attendee->markedBy ? $attendee->markedBy->name : '-' }}</td>
                                                <td>{{ $attendee->visited_at ? $attendee->visited_at->format('d M Y, h:i A') : '-' }}</td>
                                                <td>
                                                    @if($attendee->remarks)
                                                        <span class="badge bg-info">{{ Str::limit($attendee->remarks, 30) }}</span>
                                                    @else
                                                        <span class="text-muted">No remarks</span>
                                                    @endif
                                                </td>
                                                <td class="d-flex gap-1">
                                                    @if($attendee->is_approved == 0)
                                                        {{-- <button type="button" class="btn btn-info btn-sm approve-attendee" data-id="{{ $attendee->id }}">
                                                            <i class="ri-check-double-line me-1"></i> Approve
                                                        </button> --}}
                                                        <button type="button"
                                                                class="btn btn-info btn-sm approve-attendee"
                                                                data-id="{{ $attendee->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#approveModal">
                                                            <i class="ri-check-double-line me-1"></i> Approve
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm reject-attendee" data-id="{{ $attendee->id }}">
                                                            <i class="ri-close-circle-line me-1"></i> Reject
                                                        </button>
                                                    @endif
                                                    @if(!$attendee->visited_at && $attendee->is_approved == 1)
                                                        <button type="button" class="btn btn-success btn-sm mark-visited" data-id="{{ $attendee->id }}">
                                                            <i class="ri-check-line me-1"></i> Mark as Visited
                                                        </button>
                                                    @elseif($attendee->visited_at && $attendee->is_approved == 1)
                                                        <button type="button" class="btn btn-danger btn-sm mark-not-visited" data-id="{{ $attendee->id }}">
                                                            <i class="ri-close-line me-1"></i> Mark as Not Visited
                                                        </button>
                                                    @endif
                                                    {{-- <button type="button" class="btn btn-warning btn-sm add-remarks" 
                                                            data-id="{{ $attendee->id }}" 
                                                            data-remarks="{{ $attendee->remarks }}" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#remarksModal">
                                                        <i class="ri-chat-3-line me-1"></i> 
                                                        {{ $attendee->remarks ? 'Edit Remarks' : 'Add Remarks' }}
                                                    </button> --}}
                                                    <button type="button" class="btn btn-warning btn-sm edit-attendee" 
                                                            data-id="{{ $attendee->id }}"
                                                            data-name="{{ $attendee->name }}"
                                                            data-email="{{ $attendee->email }}"
                                                            data-phone="{{ $attendee->phone_number }}"
                                                            data-remarks="{{ $attendee->remarks }}"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editAttendeeModal">
                                                        <i class="ri-edit-line me-1"></i> Edit
                                                    </button>
                                                    <a href="{{ asset($attendee->ticket_pdf) }}" download class="btn btn-primary btn-sm @if($attendee->is_approved != 1) disabled @endif">
                                                        <i class="uil uil-download-alt"></i> Download Ticket
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="14" class="text-center">No Attendees Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $attendees->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="approveForm" method="POST" >
      @csrf
      <input type="hidden" name="attendee_id" id="modalAttendeeId">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="approveModalLabel">Approve Attendee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="statusSelect" class="form-label">Select Preferred Institutes</label>
            <select name="universities[]" id="statusSelect" class="form-select" placeholder="No University" multiple>
              {{-- <option value="">No university</option> --}}
                @foreach($universities as $university)
                    <option value="{{ $university->id }}">{{ $university->name }}</option>  
                @endforeach
            </select>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="timeslotFrom" class="form-label">Timeslot From</label>
                <input type="time" name="timeslot_from" id="timeslotFrom" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="timeslotTo" class="form-label">Timeslot To</label>
                <input type="time" name="timeslot_to" id="timeslotTo" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="approvalRemarks" class="form-label">Remarks (Optional)</label>
            <textarea name="remarks" id="approvalRemarks" class="form-control" rows="3" placeholder="Enter any remarks for this approval..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="approveFormBtn" class="btn btn-primary">Approve</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Remarks Modal -->
<div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="remarksForm" method="POST">
      @csrf
      <input type="hidden" name="attendee_id" id="remarksAttendeeId">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="remarksModalLabel">Add/Edit Remarks</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="remarksText" class="form-label">Remarks</label>
            <textarea name="remarks" id="remarksText" class="form-control" rows="4" placeholder="Enter remarks for this attendee..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="remarksFormBtn" class="btn btn-primary">Save Remarks</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Additional Fields Modal -->
<div class="modal fade" id="additionalFieldsModal" tabindex="-1" aria-labelledby="additionalFieldsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="additionalFieldsModalLabel">Additional Fields</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="table-light">
                  <tr>
                    <th width="40%">Field Name</th>
                    <th width="60%">Value</th>
                  </tr>
                </thead>
                <tbody id="additionalFieldsTableBody">
                  <!-- Fields will be populated by JavaScript -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Attendee Modal -->
<div class="modal fade" id="editAttendeeModal" tabindex="-1" aria-labelledby="editAttendeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editAttendeeForm" method="POST">
      @csrf
      <input type="hidden" name="attendee_id" id="editAttendeeId">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAttendeeModalLabel">Edit Attendee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="editName" class="form-label">Name</label>
            <input type="text" name="name" id="editName" class="form-control" required>
          </div>
          
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" name="email" id="editEmail" class="form-control" required>
          </div>
          
          <div class="mb-3">
            <label for="editPhone" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" id="editPhone" class="form-control">
          </div>
          
          <div class="mb-3">
            <label for="editRemarks" class="form-label">Remarks</label>
            <textarea name="remarks" id="editRemarks" class="form-control" rows="3" placeholder="Enter any remarks..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="editAttendeeFormBtn" class="btn btn-primary">Update Attendee</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('custom-js')
<script>
$(document).ready(function () {

    // Bulk selection functionality
    let selectedAttendees = [];

    // Handle select all checkbox
    $('#selectAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        
        if (isChecked) {
            // Select all attendees across all pages
            selectAllAttendees();
        } else {
            // Deselect all
            selectedAttendees = [];
            $('.attendee-checkbox:not(:disabled)').prop('checked', false);
            updateBulkActionBar();
        }
    });

    // Function to select all attendees across all pages
    function selectAllAttendees() {
        const currentFilter = $('input[name="filter"]').val() || '';
        
        $.ajax({
            url: "{{ route('event-attendees-all-ids', $event->id) }}",
            type: 'GET',
            data: {
                filter: currentFilter
            },
            beforeSend: function() {
                $('#selectAll').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    selectedAttendees = response.attendee_ids;
                    
                    // Check all visible checkboxes on current page
                    $('.attendee-checkbox:not(:disabled)').each(function() {
                        const attendeeId = $(this).val();
                        if (selectedAttendees.includes(parseInt(attendeeId))) {
                            $(this).prop('checked', true);
                        }
                    });
                    
                    // Update select all checkbox state
                    $('#selectAll').prop('checked', true).prop('indeterminate', false);
                    updateBulkActionBar();
                } else {
                    alert('Failed to load all attendee IDs. Please try again.');
                }
            },
            error: function() {
                alert('Failed to load all attendee IDs. Please try again.');
            },
            complete: function() {
                $('#selectAll').prop('disabled', false);
            }
        });
    }

    // Handle individual attendee checkbox selection
    $(document).on('change', '.attendee-checkbox', function() {
        const attendeeId = parseInt($(this).val());
        
        if ($(this).is(':checked')) {
            if (!selectedAttendees.includes(attendeeId)) {
                selectedAttendees.push(attendeeId);
            }
        } else {
            selectedAttendees = selectedAttendees.filter(id => id !== attendeeId);
        }
        
        // Update select all checkbox state
        const totalCheckboxes = $('.attendee-checkbox:not(:disabled)').length;
        const checkedCheckboxes = $('.attendee-checkbox:not(:disabled):checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#selectAll').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes && selectedAttendees.length === totalCheckboxes) {
            // Only show as fully selected if all visible are checked AND no other pages have selections
            $('#selectAll').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#selectAll').prop('indeterminate', true);
        }
        
        updateBulkActionBar();
    });

    // Update bulk action bar visibility and count
    function updateBulkActionBar() {
        const count = selectedAttendees.length;
        const visibleCount = $('.attendee-checkbox:not(:disabled):checked').length;
        const totalVisible = $('.attendee-checkbox:not(:disabled)').length;
        
        $('#selectedCount').text(count);
        
        // Update selection info
        if (count > totalVisible) {
            $('#selectionInfo').text(`(${visibleCount} on this page, ${count} total)`);
        } else {
            $('#selectionInfo').text(`(${visibleCount} on this page)`);
        }
        
        if (count > 0) {
            $('#bulkActionBar').show();
        } else {
            $('#bulkActionBar').hide();
        }
    }

    // Clear selection
    $('#clearSelectionBtn').on('click', function() {
        selectedAttendees = [];
        $('.attendee-checkbox').prop('checked', false);
        $('#selectAll').prop('indeterminate', false).prop('checked', false);
        updateBulkActionBar();
    });

    // Bulk approve selected attendees
    $('#bulkApproveBtn').on('click', function() {
        if (selectedAttendees.length === 0) {
            alert('Please select attendees to approve.');
            return;
        }
        
        if (confirm(`Are you sure you want to approve ${selectedAttendees.length} selected attendee(s)?`)) {
            bulkAction('approve', selectedAttendees);
        }
    });

    // Bulk reject selected attendees
    $('#bulkRejectBtn').on('click', function() {
        if (selectedAttendees.length === 0) {
            alert('Please select attendees to reject.');
            return;
        }
        
        if (confirm(`Are you sure you want to reject ${selectedAttendees.length} selected attendee(s)?`)) {
            bulkAction('reject', selectedAttendees);
        }
    });

    // Handle bulk actions
    function bulkAction(action, attendeeIds) {
        const button = action === 'approve' ? $('#bulkApproveBtn') : $('#bulkRejectBtn');
        const originalText = button.html();
        const loadingText = action === 'approve' ? 
            '<i class="ri-loader-4-line me-1"></i> Approving...' : 
            '<i class="ri-loader-4-line me-1"></i> Rejecting...';
        
        button.html(loadingText).prop('disabled', true);
        
        $.ajax({
            url: `/admin/bulk-${action}-attendees`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                attendee_ids: attendeeIds,
                event_id: '{{ $event->id }}'
            },
            success: function(response) {
                if (response.success) {
                    alertMessage(response.message, false);
                    // Clear selection and reload page
                    selectedAttendees = [];
                    $('.attendee-checkbox').prop('checked', false);
                    $('#selectAll').prop('indeterminate', false).prop('checked', false);
                    updateBulkActionBar();
                    setTimeout(function(){ location.reload(); }, 1000);
                } else {
                    alertMessage(response.message, true);
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while processing the request.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alertMessage(errorMessage, true);
            },
            complete: function() {
                button.html(originalText).prop('disabled', false);
            }
        });
    }

    // Handle approve button click
    $('.approve-attendee').on('click', function () {
        var attendeeId = $(this).data('id');
        $('#modalAttendeeId').val(attendeeId);
        // Clear the remarks field when opening the modal
        $('#approvalRemarks').val('');
    });

    // Handle add remarks button click
    $('.add-remarks').on('click', function () {
        var attendeeId = $(this).data('id');
        var currentRemarks = $(this).data('remarks');
        
        $('#remarksAttendeeId').val(attendeeId);
        $('#remarksText').val(currentRemarks || '');
        
        // Update modal title based on whether remarks exist
        var modalTitle = currentRemarks ? 'Edit Remarks' : 'Add Remarks';
        $('#remarksModalLabel').text(modalTitle);
    });

    // Handle edit attendee button click
    $(document).on('click', '.edit-attendee', function () {
        var attendeeId = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var remarks = $(this).data('remarks');
        
        $('#editAttendeeId').val(attendeeId);
        $('#editName').val(name);
        $('#editEmail').val(email);
        $('#editPhone').val(phone);
        $('#editRemarks').val(remarks || '');
        
        // Update modal title
        $('#editAttendeeModalLabel').text('Edit Attendee - ' + name);
    });

    // Handle view additional fields button click
    $(document).on('click', '.view-additional-fields', function () {
        var attendeeId = $(this).data('attendee-id');
        var fields = $(this).data('fields');
        
        // Clear previous content
        $('#additionalFieldsTableBody').empty();
        
        // Populate the modal with fields
        if (fields && Object.keys(fields).length > 0) {
            $.each(fields, function(key, value) {
                var fieldName = key.replace(/_/g, ' ').replace(/\b\w/g, function(l) {
                    return l.toUpperCase();
                });
                
                var row = '<tr>' +
                    '<td><strong>' + fieldName + '</strong></td>' +
                    '<td>' + (value || '<span class="text-muted">No value</span>') + '</td>' +
                    '</tr>';
                $('#additionalFieldsTableBody').append(row);
            });
        } else {
            $('#additionalFieldsTableBody').append('<tr><td colspan="2" class="text-center text-muted">No additional fields available</td></tr>');
        }
        
        // Update modal title with attendee info
        $('#additionalFieldsModalLabel').text('Additional Fields - Attendee #' + attendeeId);
    });

    $('.mark-visited').click(function () {
        var button = $(this);
        var attendeeId = button.data('id');
        var csrfToken = '{{ csrf_token() }}';
        var originalText = button.html();
        button.html('<i class="ri-loader-4-line me-1"></i> Loading...');
        $.ajax({
            url: '/admin/mark-attendee-visited/' + attendeeId,
            type: 'POST',
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    button.html('<i class="ri-check-line me-1"></i> Visited!');
                    button.prop('disabled', true);
                    alertMessage(response.message, false);
                } else {
                    button.html(originalText);
                    alertMessage(response.message, true);
                }
            },
            error: function () {
                button.html(originalText);
                alert('Failed to mark as visited. Please try again.');
            }
        });
    });
    $('.mark-not-visited').click(function () {
        var button = $(this);
        var attendeeId = button.data('id');
        var csrfToken = '{{ csrf_token() }}';
        var originalText = button.html();
        button.html('<i class="ri-loader-4-line me-1"></i> Loading...');
        $.ajax({
            url: '/admin/mark-attendee-not-visited/' + attendeeId,
            type: 'POST',
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    button.html('<i class="ri-check-line me-1"></i> Not Visited!');
                    button.prop('disabled', true);
                    alertMessage(response.message, false);
                } else {
                    button.html(originalText);
                    alertMessage(response.message, true);
                }
            },
            error: function () {
                button.html(originalText);
                alert('Failed to mark as visited. Please try again.');
            }
        });
    });
    $('.reject-attendee').click(function () {
        var button = $(this);
        var attendeeId = button.data('id');
        var csrfToken = '{{ csrf_token() }}';
        var originalText = button.html();
        button.html('<i class="ri-loader-4-line me-1"></i> Rejecting...');
        $.ajax({
            url: '/admin/reject-attendee/' + attendeeId,
            type: 'POST',
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    button.html('<i class="ri-close-circle-line me-1"></i> Rejected!');
                    button.prop('disabled', true);
                    alertMessage(response.message, false);
                    setTimeout(function(){ location.reload(); }, 1000);
                } else {
                    button.html(originalText);
                    alertMessage(response.message, true);
                }
            },
            error: function () {
                button.html(originalText);
                alert('Failed to reject attendee. Please try again.');
            }
        });
    });
});

// Timeslot validation
$('#timeslotFrom, #timeslotTo').on('change', function() {
    var fromTime = $('#timeslotFrom').val();
    var toTime = $('#timeslotTo').val();
    
    if (fromTime && toTime) {
        if (fromTime >= toTime) {
            alert('End time must be after start time');
            $('#timeslotTo').val('');
        }
    }
});

//approve form submission
$('#approveForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#approveForm'), "{{ route('approve-attendee') }}", $('#approveFormBtn'), '',
                onRequestSuccess, $('#approveModal'));
        }
    });

// Remarks form submission
$('#remarksForm').on('submit', function(e) {
    e.preventDefault();
    
    var button = $('#remarksFormBtn');
    var originalText = button.html();
    button.html('<i class="ri-loader-4-line me-1"></i> Saving...').prop('disabled', true);
    
    var formData = {
        _token: '{{ csrf_token() }}',
        attendee_id: $('#remarksAttendeeId').val(),
        remarks: $('#remarksText').val()
    };
    
    $.ajax({
        url: '/admin/update-attendee-remarks',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                alertMessage(response.message, false);
                $('#remarksModal').modal('hide');
                setTimeout(function(){ location.reload(); }, 1000);
            } else {
                alertMessage(response.message, true);
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while saving remarks.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            alertMessage(errorMessage, true);
        },
        complete: function() {
            button.html(originalText).prop('disabled', false);
        }
    });
});

// Edit attendee form submission
$('#editAttendeeForm').on('submit', function(e) {
    e.preventDefault();
    
    var button = $('#editAttendeeFormBtn');
    var originalText = button.html();
    button.html('<i class="ri-loader-4-line me-1"></i> Updating...').prop('disabled', true);
    
    var formData = {
        _token: '{{ csrf_token() }}',
        attendee_id: $('#editAttendeeId').val(),
        name: $('#editName').val(),
        email: $('#editEmail').val(),
        phone_number: $('#editPhone').val(),
        remarks: $('#editRemarks').val()
    };
    
    $.ajax({
        url: '/admin/update-attendee',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                alertMessage(response.message, false);
                $('#editAttendeeModal').modal('hide');
                setTimeout(function(){ location.reload(); }, 1000);
            } else {
                alertMessage(response.message, true);
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while updating attendee.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            alertMessage(errorMessage, true);
        },
        complete: function() {
            button.html(originalText).prop('disabled', false);
        }
    });
}); 
</script>
@endsection