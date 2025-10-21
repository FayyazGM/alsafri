@extends('admin.layout.index')
@section('title', 'Edit Media')

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
                    <li class="breadcrumb-item active" aria-current="page">Edit Media</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Edit Media</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Edit Media</div>
                    </div>
                    <div class="card-body">
                        <form id="mediaForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="event_id" class="form-label">Event <span class="text-danger">*</span></label>
                                        <select name="event_id" id="event_id" class="form-control" required>
                                            <option value="">Select Event</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event->id }}" {{ $event->id == $media->event_id ? 'selected' : '' }}>{{ $event->name }}</option>
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
                                            <option value="video" {{ $media->media_type == 'video' ? 'selected' : '' }}>Video</option>
                                            <option value="brochure" {{ $media->media_type == 'brochure' ? 'selected' : '' }}>Brochure (PDF/Image)</option>
                                            <option value="file" {{ $media->media_type == 'file' ? 'selected' : '' }}>File/Document</option>
                                        </select>
                                        <span class="text-danger" id="media_type_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title (Optional)</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $media->title) }}" placeholder="Enter media title">
                                        <span class="text-danger" id="title_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">File (Leave empty to keep current file)</label>
                                        <input type="file" class="form-control" id="file" name="file">
                                        <div class="form-text">
                                            <strong>Current file:</strong> {{ $media->file_name }} ({{ $media->file_size_human }})<br>
                                            <div id="fileInfo">
                                                <strong>Allowed file types:</strong><br>
                                                <span id="allowedTypes">
                                                    @if($media->media_type === 'video')
                                                        MP4, AVI, MOV, WMV, FLV, WebM, MKV
                                                    @elseif($media->media_type === 'brochure')
                                                        PDF, JPG, JPEG, PNG, GIF, WebP
                                                    @else
                                                        PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, JPEG, PNG, GIF, WebP
                                                    @endif
                                                </span><br>
                                                <strong>Maximum file size:</strong> 10MB
                                            </div>
                                        </div>
                                        <span class="text-danger" id="file_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description (Optional)</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter media description">{{ old('description', $media->description) }}</textarea>
                                        <span class="text-danger" id="description_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('admin.media.show', $media->id) }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary" id="updateMediaBtn">Update Media</button>
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
            var btn = $('#updateMediaBtn');
            var btnText = btn.html();
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin.media.update', $media->id) }}",
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                beforeSend: function () {
                    btn.prop('disabled', true);
                    btn.html('<i class="fa fa-spinner fa-spin me-1"></i> Updating...');
                },
                success: function (res) {
                    btn.prop('disabled', false);
                    btn.html(btnText);
                    
                    if (res.success) {
                        alertMessage(res.message, false);
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.media.show', $media->id) }}";
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
                            alertMessage('An error occurred while updating the file.', true);
                        }
                    } catch (e) {
                        alertMessage('An error occurred while updating the file.', true);
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
