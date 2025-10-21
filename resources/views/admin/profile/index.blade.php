@extends('admin.layout.index')
@section('title', 'Profile')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Profile</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Update Profile</h1>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Profile Information</div>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Profile Image</label>
                                        <div class="text-center mb-3">
                                            @if($admin->avatar)
                                                <img src="{{ Storage::url($admin->avatar) }}" alt="Profile" class="rounded-circle avatar avatar-xl">
                                            @else
                                                <img src="{{ asset('admin_assets/images/faces/default.jpg') }}" alt="Profile" class="rounded-circle avatar avatar-xl">
                                            @endif
                                        </div>
                                        <input type="file" class="form-control" id="avatar" name="avatar">
                                        <span class="text-danger" id="avatar_error"></span>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                                <span class="text-danger" id="name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                                <span class="text-danger" id="email_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                                                <span class="text-danger" id="phone_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="1">{{ old('address', $admin->address) }}</textarea>
                                                <span class="text-danger" id="address_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($admin->user_type === 'exhibitor')
                            <!-- Exhibitor-specific fields -->
                            <div class="card custom-card mt-4">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Exhibitor Information</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="university" class="form-label">University</label>
                                                <input type="text" class="form-control" id="university" name="university" value="{{ old('university', $admin->university) }}">
                                                <span class="text-danger" id="university_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="logo" class="form-label">Logo</label>
                                                <div class="text-center mb-3">
                                                    @if($admin->logo)
                                                        <img src="{{ Storage::url($admin->logo) }}" alt="Logo" class="rounded" style="max-width: 100px; max-height: 100px;">
                                                    @else
                                                        <div class="border rounded p-3 text-muted">No logo uploaded</div>
                                                    @endif
                                                </div>
                                                <input type="file" class="form-control" id="logo" name="logo">
                                                <span class="text-danger" id="logo_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="facebook_url" class="form-label">Facebook URL</label>
                                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $admin->facebook_url) }}" placeholder="https://facebook.com/yourpage">
                                                <span class="text-danger" id="facebook_url_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="instagram_url" class="form-label">Instagram URL</label>
                                                <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $admin->instagram_url) }}" placeholder="https://instagram.com/yourpage">
                                                <span class="text-danger" id="instagram_url_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $admin->linkedin_url) }}" placeholder="https://linkedin.com/in/yourprofile">
                                                <span class="text-danger" id="linkedin_url_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="youtube_url" class="form-label">YouTube URL</label>
                                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $admin->youtube_url) }}" placeholder="https://youtube.com/channel/yourchannel">
                                                <span class="text-danger" id="youtube_url_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="twitter_url" class="form-label">Twitter URL</label>
                                                <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $admin->twitter_url) }}" placeholder="https://twitter.com/yourhandle">
                                                <span class="text-danger" id="twitter_url_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="card custom-card mt-4">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Change Password</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                                <span class="text-danger" id="password_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->
    </div>
</div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#profileForm').validate({
            submitHandler: function() {
                'use strict';
                handleAjaxCall($('#profileForm'), "{{ route('admin.profile.update') }}", $('#updateProfileBtn'), '' , onRequestSuccess , $('#editUserModal'))
            }
        });
    });
</script>
@endsection 