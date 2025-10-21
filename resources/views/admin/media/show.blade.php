@extends('admin.layout.index')
@section('title', 'Media Details')

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
                    <li class="breadcrumb-item active" aria-current="page">Media Details</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Media Details</h1>
            </div>
            <div>
                <a href="{{ route('admin.media.edit', $media->id) }}" class="btn btn-primary me-2">
                    <i class="ri-pencil-line"></i> Edit
                </a>
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line"></i> Back
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Media Information</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Title:</label>
                                    <p class="mb-0">{{ $media->title ?: 'Untitled' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Event:</label>
                                    <p class="mb-0">{{ $media->event->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Media Type:</label>
                                    <p class="mb-0">
                                        @if($media->media_type === 'video')
                                            <span class="badge bg-danger">Video</span>
                                        @elseif($media->media_type === 'brochure')
                                            <span class="badge bg-info">Brochure</span>
                                        @else
                                            <span class="badge bg-secondary">File</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">File Name:</label>
                                    <p class="mb-0">{{ $media->file_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">File Size:</label>
                                    <p class="mb-0">{{ $media->file_size_human }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Uploaded:</label>
                                    <p class="mb-0">{{ $media->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            @if($media->description)
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Description:</label>
                                    <p class="mb-0">{{ $media->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Media Preview</div>
                    </div>
                    <div class="card-body text-center">
                        @if($media->isVideo())
                            <video controls style="max-width: 100%; max-height: 300px;">
                                <source src="{{ $media->file_url }}" type="{{ $media->mime_type }}">
                                Your browser does not support the video tag.
                            </video>
                        @elseif($media->isBrochure() && str_contains($media->mime_type, 'image'))
                            <img src="{{ $media->file_url }}" alt="{{ $media->title ?: $media->file_name }}" style="max-width: 100%; max-height: 300px;" class="img-fluid">
                        @else
                            <div class="text-center p-4">
                                @if(str_contains($media->mime_type, 'pdf'))
                                    <i class="ri-file-pdf-line text-danger" style="font-size: 4rem;"></i>
                                @elseif(str_contains($media->mime_type, 'word'))
                                    <i class="ri-file-word-line text-primary" style="font-size: 4rem;"></i>
                                @elseif(str_contains($media->mime_type, 'excel'))
                                    <i class="ri-file-excel-line text-success" style="font-size: 4rem;"></i>
                                @elseif(str_contains($media->mime_type, 'powerpoint'))
                                    <i class="ri-file-ppt-line text-warning" style="font-size: 4rem;"></i>
                                @elseif(str_contains($media->mime_type, 'zip') || str_contains($media->mime_type, 'rar'))
                                    <i class="ri-file-zip-line text-info" style="font-size: 4rem;"></i>
                                @else
                                    <i class="ri-file-line text-secondary" style="font-size: 4rem;"></i>
                                @endif
                                <p class="mt-3 mb-0">{{ $media->file_name }}</p>
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <a href="{{ $media->file_url }}" target="_blank" class="btn btn-primary">
                                <i class="ri-download-line"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
