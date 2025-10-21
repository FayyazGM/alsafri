@extends('admin.layout.index')
@section('title', 'Import Attendees')

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
                    <li class="breadcrumb-item active" aria-current="page">Import Attendees</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Import Attendees</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Import Attendees from CSV File
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">Instructions:</h6>
                                    <ol class="mb-0">
                                        <li>Download the CSV template below</li>
                                        <li>Fill in the attendee information</li>
                                        <li><strong>Other Fields:</strong> Use JSON format to add custom fields. Example: <code>{"cnic_#":"35202-1234567-8","company":"ABC Corp"}</code></li>
                                        <li>Save the file as CSV format</li>
                                        <li>Upload the file here</li>
                                    </ol>
                                </div>
                                
                                <div class="mb-3">
                                    <a href="{{ route('download-attendees-template') }}" class="btn btn-success">
                                        <i class="ri-download-line me-2"></i>Download CSV Template
                                    </a>
                                </div>
                                
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">CSV Format:</h6>
                                    <p class="mb-2"><strong>Required columns:</strong> name, email</p>
                                    <p class="mb-2"><strong>Optional columns:</strong> phone_number, other_fields</p>
                                    <p class="mb-0"><strong>Other Fields format:</strong> JSON string with key-value pairs</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <form id="importForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="event_id" class="form-label">Select Event <span class="text-danger">*</span></label>
                                        <select class="form-select" id="event_id" name="event_id" required>
                                            <option value="">Choose an event...</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event->id }}">
                                                    {{ $event->name }} - {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="file" class="form-label">CSV File <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.txt" required>
                                        <div class="form-text">Maximum file size: 2MB. Supported formats: CSV, TXT</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary" id="importBtn">
                                            <i class="ri-upload-line me-2"></i>Import Attendees
                                        </button>
                                        {{-- <button type="button" class="btn btn-secondary ms-2" id="testBtn">
                                            <i class="ri-bug-line me-2"></i>Test Results
                                        </button> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id="importResults" style="display: none; margin-top: 20px;">
                            <hr>
                            <h6 class="mb-3">Import Results:</h6>
                            <div id="resultsContent"></div>
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
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submitted');
        
        // Show immediate feedback
        console.log('Form submitted! Check console for details.');
        
        const formData = new FormData(this);
        const importBtn = $('#importBtn');
        const originalText = importBtn.html();
        
        // Disable button and show loading
        importBtn.prop('disabled', true).html('<i class="ri-loader-4-line me-2"></i>Importing...');
        
        console.log('Form data:', formData);
        console.log('URL:', '{{ route("import-attendees") }}');
        
        $.ajax({
            url: '{{ route("import-attendees") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success response:', response);
                console.log('Response type:', typeof response);
                
                // Ensure response is an object
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('Failed to parse response:', e);
                    }
                }
                
                if (response && response.success) {
                    let resultsHtml = `
                        <div class="alert alert-success">
                            <h6>Import Completed Successfully!</h6>
                            <p>${response.message}</p>
                            <p><strong>Imported:</strong> ${response.imported} attendees</p>
                        </div>
                    `;
                    
                    if (response.errors && response.errors.length > 0) {
                        resultsHtml += `
                            <div class="alert alert-warning">
                                <h6>Errors Found:</h6>
                                <ul>
                                    ${response.errors.map(error => `<li>${error}</li>`).join('')}
                                </ul>
                            </div>
                        `;
                    }
                    
                    console.log('Setting results HTML:', resultsHtml);
                    console.log('Results div found:', $('#resultsContent').length);
                    console.log('Import results div found:', $('#importResults').length);
                    
                    $('#resultsContent').html(resultsHtml);
                    $('#importResults').show();
                    
                    console.log('Results div should be visible now');
                    
                    // Reset form
                    $('#importForm')[0].reset();
                    
                } else {
                    let errorHtml = `
                        <div class="alert alert-danger">
                            <h6>Import Failed!</h6>
                            <p>${response ? response.message : 'Unknown error occurred'}</p>
                        </div>
                    `;
                    
                    console.log('Setting error HTML:', errorHtml);
                    $('#resultsContent').html(errorHtml);
                    $('#importResults').show();
                    console.log('Error results div should be visible now');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error response:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
                
                let errorMessage = 'An error occurred during import.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        errorMessage = xhr.responseText;
                    }
                }
                
                $('#resultsContent').html(`
                    <div class="alert alert-danger">
                        <h6>Import Failed!</h6>
                        <p>${errorMessage}</p>
                        <small>Status: ${status}</small>
                    </div>
                `);
                $('#importResults').show();
            },
            complete: function() {
                // Re-enable button
                importBtn.prop('disabled', false).html(originalText);
            }
        });
        
        // Test button to check if results div works
        $('#testBtn').on('click', function() {
            console.log('Test button clicked');
            console.log('Results div found:', $('#resultsContent').length);
            console.log('Import results div found:', $('#importResults').length);
            
            $('#resultsContent').html(`
                <div class="alert alert-info">
                    <h6>Test Message!</h6>
                    <p>This is a test to see if the results div is working.</p>
                    <p>Current time: ${new Date().toLocaleTimeString()}</p>
                </div>
            `);
            $('#importResults').show();
            
            console.log('Test results div should be visible now');
        });
    });
});
</script>
@endsection 