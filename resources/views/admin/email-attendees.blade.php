@extends('admin.layout.index')
@section('title', 'Email Attendees')

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
                    <li class="breadcrumb-item active" aria-current="page">Email Attendees</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Email Attendees</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Send Email to Attendees</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.email-attendees-send') }}" method="POST" id="emailForm">
                            @csrf
                            
                            <!-- Email Content -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Email Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" placeholder="Enter email subject" required>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Email Content <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="8" placeholder="Enter your email content here..." required></textarea>
                                    <small class="text-muted">You can use HTML tags for formatting. Available placeholders: {name}, {email}, {event_name}</small>
                                </div>
                            </div>

                            <!-- Filters Section -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="mb-3">Filter Attendees</h6>
                                </div>
                                
                                <!-- Event Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event</label>
                                    <select name="event_id" id="eventFilter" class="form-control">
                                        <option value="">All Events</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- University Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">University</label>
                                    <select name="university_id" id="universityFilter" class="form-control">
                                        <option value="">All Universities</option>
                                        @foreach($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Registration Date Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Registration Date From</label>
                                    <input type="date" name="registration_date_from" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Registration Date To</label>
                                    <input type="date" name="registration_date_to" class="form-control">
                                </div>

                                <!-- Approval Status Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Approval Status</label>
                                    <select name="approval_status" class="form-control">
                                        <option value="">All</option>
                                        <option value="approved">Approved Only</option>
                                        <option value="pending">Pending Only</option>
                                    </select>
                                </div>

                                <!-- Attendance Status Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Attendance Status</label>
                                    <select name="attendance_status" class="form-control">
                                        <option value="">All</option>
                                        <option value="present">Present Only</option>
                                        <option value="absent">Absent Only</option>
                                    </select>
                                </div>

                                <!-- Event Type Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Type</label>
                                    <select name="event_type" class="form-control">
                                        <option value="">All Types</option>
                                        <option value="physical">Physical Events</option>
                                        <option value="virtual">Virtual Events</option>
                                    </select>
                                </div>

                                <!-- Event Status Filter -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Event Status</label>
                                    <select name="event_status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="upcoming">Upcoming Events</option>
                                        <option value="ongoing">Ongoing Events</option>
                                        <option value="completed">Completed Events</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-info" id="previewBtn">
                                        <i class="ri-eye-line"></i> Preview Recipients
                                    </button>
                                    <div id="previewResults" class="mt-3" style="display: none;">
                                        <div class="alert alert-info">
                                            <strong>Preview Results:</strong>
                                            <div id="previewContent"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Send Options -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h6 class="mb-3">Send Options</h6>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="send_test_email" id="sendTestEmail">
                                        <label class="form-check-label" for="sendTestEmail">
                                            Send test email to admin first
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="send_individual" id="sendIndividual" checked>
                                        <label class="form-check-label" for="sendIndividual">
                                            Send individual emails (recommended)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" id="sendEmailBtn">
                                        <i class="ri-send-plane-line"></i> Send Email
                                    </button>
                                    <button type="button" class="btn btn-secondary ms-2" onclick="resetForm()">
                                        <i class="ri-refresh-line"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
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
    // Preview functionality
    $('#previewBtn').on('click', function() {
        var formData = $('#emailForm').serializeArray();
        
        // Ensure boolean fields are always sent for preview
        formData.push({name: 'send_test_email', value: $('#sendTestEmail').is(':checked') ? '1' : '0'});
        formData.push({name: 'send_individual', value: $('#sendIndividual').is(':checked') ? '1' : '0'});
        
        // Convert to URL-encoded string
        var formDataString = $.param(formData);
        
        $.ajax({
            url: '{{ route("admin.email-attendees-preview") }}',
            type: 'POST',
            data: formDataString,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#previewBtn').prop('disabled', true).html('<i class="ri-loader-4-line"></i> Loading...');
            },
            success: function(response) {
                if (response.success) {
                    // Store attendees data globally for toggle functionality
                    window.previewAttendees = response.attendees || [];
                    
                    // Build email list HTML
                    var emailListHtml = '';
                    if (response.attendees && response.attendees.length > 0) {
                        var showAll = response.attendees.length <= 10; // Show all if 10 or fewer
                        var displayCount = showAll ? response.attendees.length : 10;
                        
                        emailListHtml = `<div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Email Recipients (${response.attendees.length} total):</strong>
                                ${!showAll ? '<button type="button" class="btn btn-sm btn-outline-primary" id="toggleBtn" onclick="toggleEmailList()">Show All</button>' : ''}
                            </div>
                            <div class="mt-2" id="emailList" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; padding: 10px; border-radius: 4px;">`;
                        
                        for (var i = 0; i < displayCount; i++) {
                            var attendee = response.attendees[i];
                            emailListHtml += `<div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                <div>
                                    <strong>${attendee.name}</strong><br>
                                    <small class="text-muted">${attendee.email}</small>
                                </div>
                                <small class="text-info">${attendee.event_name}</small>
                            </div>`;
                        }
                        
                        if (!showAll) {
                            emailListHtml += `<div class="text-center py-2 text-muted">
                                <small>... and ${response.attendees.length - 10} more recipients</small>
                            </div>`;
                        }
                        
                        emailListHtml += '</div></div>';
                    }
                    
                    $('#previewContent').html(`
                        <p><strong>Total Recipients:</strong> ${response.total}</p>
                        <p><strong>Events:</strong> ${response.events}</p>
                        <p><strong>Universities:</strong> ${response.universities}</p>
                        <p><strong>Date Range:</strong> ${response.dateRange}</p>
                        <p><strong>Filters Applied:</strong> ${response.filters}</p>
                        ${emailListHtml}
                    `);
                    $('#previewResults').show();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error occurred while previewing recipients.');
            },
            complete: function() {
                $('#previewBtn').prop('disabled', false).html('<i class="ri-eye-line"></i> Preview Recipients');
            }
        });
    });

    // Form submission
    $('#emailForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to send this email to the selected attendees?')) {
            return false;
        }
        
        var formData = new FormData(this);
        
        // Ensure boolean fields are always sent
        formData.append('send_test_email', $('#sendTestEmail').is(':checked') ? '1' : '0');
        formData.append('send_individual', $('#sendIndividual').is(':checked') ? '1' : '0');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#sendEmailBtn').prop('disabled', true).html('<i class="ri-loader-4-line"></i> Sending...');
            },
            success: function(response) {
                if (response.success) {
                    alert('Email sent successfully to ' + response.sent_count + ' recipients!');
                    resetForm();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error occurred while sending email.');
            },
            complete: function() {
                $('#sendEmailBtn').prop('disabled', false).html('<i class="ri-send-plane-line"></i> Send Email');
            }
        });
    });
});

function resetForm() {
    $('#emailForm')[0].reset();
    $('#previewResults').hide();
}

function toggleEmailList() {
    if (!window.previewAttendees || window.previewAttendees.length === 0) return;
    
    var emailListDiv = document.getElementById('emailList');
    var toggleBtn = document.getElementById('toggleBtn');
    
    if (emailListDiv.innerHTML.includes('... and')) {
        // Show all attendees
        var fullListHtml = '';
        window.previewAttendees.forEach(function(attendee) {
            fullListHtml += `<div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                <div>
                    <strong>${attendee.name}</strong><br>
                    <small class="text-muted">${attendee.email}</small>
                </div>
                <small class="text-info">${attendee.event_name}</small>
            </div>`;
        });
        emailListDiv.innerHTML = fullListHtml;
        toggleBtn.textContent = 'Show Less';
    } else {
        // Show only first 10
        var shortListHtml = '';
        for (var i = 0; i < Math.min(10, window.previewAttendees.length); i++) {
            var attendee = window.previewAttendees[i];
            shortListHtml += `<div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                <div>
                    <strong>${attendee.name}</strong><br>
                    <small class="text-muted">${attendee.email}</small>
                </div>
                <small class="text-info">${attendee.event_name}</small>
            </div>`;
        }
        if (window.previewAttendees.length > 10) {
            shortListHtml += `<div class="text-center py-2 text-muted">
                <small>... and ${window.previewAttendees.length - 10} more recipients</small>
            </div>`;
        }
        emailListDiv.innerHTML = shortListHtml;
        toggleBtn.textContent = 'Show All';
    }
}
</script>
@endsection

