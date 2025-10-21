@extends('admin.layout.index')
@section('title', 'Upload Media')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.media.index') }}">Media Management</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Media</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Upload Media</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Upload New Media</div>
                    </div>
                    <div class="card-body">
                        <form id="mediaForm" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="event_id" class="form-label">Event <span class="text-danger">*</span></label>
                                        <select name="event_id" id="event_id" class="form-control" required>
                                            <option value="">Select Event</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="event_id_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="media_type" class="form-label">Media Type <span class="text-danger">*</span></label>
                                        <select name="media_type" id="media_type" class="form-control" required>
                                            <option value="">Select Media Type</option>
                                            <option value="video">Video</option>
                                            <option value="brochure">Brochure (PDF/Image)</option>
                                            <option value="file">File/Document</option>
                                        </select>
                                        <span class="text-danger" id="media_type_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title (Optional)</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter media title">
                                        <span class="text-danger" id="title_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="file" name="file" required>
                                        <div class="form-text">
                                            <div id="fileInfo">
                                                <strong>Allowed file types:</strong><br>
                                                <span id="allowedTypes">Select media type first</span><br>
                                                <strong>Maximum file size:</strong> 10MB
                                            </div>
                                        </div>
                                        <span class="text-danger" id="file_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description (Optional)</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter media description"></textarea>
                                        <span class="text-danger" id="description_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary" id="uploadMediaBtn">Upload Media</button>
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
    // Update allowed file types based on media type selection
    $('#media_type').on('change', function() {
        var mediaType = $(this).val();
        var allowedTypes = '';
        
        switch(mediaType) {
            case 'video':
                allowedTypes = 'MP4, AVI, MOV, WMV, FLV, WebM, MKV';
                break;
            case 'brochure':
                allowedTypes = 'PDF, JPG, JPEG, PNG, GIF, WebP';
                break;
            case 'file':
                allowedTypes = 'PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF, WebP';
                break;
            default:
                allowedTypes = 'Select media type first';
        }
        
        $('#allowedTypes').text(allowedTypes);
    });

    // Form validation and submission
    $('#mediaForm').validate({
        submitHandler: function() {
            'use strict';
            // Custom AJAX call for media forms to handle both success and error responses
            var formData = new FormData($('#mediaForm')[0]);
            var btn = $('#uploadMediaBtn');
            var btnText = btn.html();
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin.media.store') }}",
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                beforeSend: function () {
                    btn.prop('disabled', true);
                    btn.html('<i class="fa fa-spinner fa-spin me-1"></i> Uploading...');
                },
                success: function (res) {
                    btn.prop('disabled', false);
                    btn.html(btnText);
                    
                    if (res.success) {
                        alertMessage(res.message, false);
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.media.index') }}";
                        }, 1500);
                    } else {
                        alertMessage(res.message, true);
                    }
                },
                error: function (xhr, status, error) {
                    btn.prop('disabled', false);
                    btn.html(btnText);
                    
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            alertMessage(response.message, true);
                        } else {
                            alertMessage('An error occurred while uploading the file.', true);
                        }
                    } catch (e) {
                        alertMessage('An error occurred while uploading the file.', true);
                    }
                }
            });
        }
    });
    
    // Custom success handler for media forms
    function onMediaRequestSuccess(response, button, buttonText, redirectUrl, form) {
        if (response.success == true) {
            alertMessage(response.message, false);
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 2000);
        } else {
            alertMessage(response.message, true);
            button.prop('disabled', false);
            button.html(buttonText);
            setTimeout(function () {
                $('.loading-bar').css('transition', 'none');
                $('.loading-bar').css('width', 0);
            }, 500);
        }
    }
});
</script>
@endsection
