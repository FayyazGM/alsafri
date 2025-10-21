@extends('admin.layout.index')
@section('title', 'Manage Users')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
            <div>
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href('javascript:void(0);')">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Manage Users</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="ri-add-line align-bottom"></i> Add User
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="userList">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by name , email , user type , phone number..." value="{{ $filter }}" name="filter">
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
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}</td>
                                                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge bg-primary">{{ ucfirst($user->user_type) }}</span></td>
                                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary editBtn"
                                                        data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-user_type="{{ $user->user_type }}"
                                                        data-avatar="{{ $user->avatar }}"
                                                        data-address="{{ $user->address }}"
                                                        data-phone="{{ $user->phone }}"
                                                        data-country_id="{{ $user->country_id }}"
                                                        data-university="{{ $user->university }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                    >
                                                        <i class="ri-pencil-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No Users Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $users->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('modals')
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="addUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">User Type</label>
                        <select name="user_type" class="form-control" required>
                            <option value="">Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="consultant">Consultant</option>
                            <option value="student">Student</option>
                            <option value="exhibitor">Exhibitor</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" minlength="8" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-control" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" @if($country->name == 'Pakistan') selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="avatar" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6" id="universityField" style="display: none;">
                        <label class="form-label">University</label>
                        <select name="university" class="form-control">
                            <option value="">Select University</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->name }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Full Address" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addUserBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="editUserId">
                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="editUserName" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editUserEmail" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">User Type</label>
                        <select name="user_type" id="editUserType" class="form-control" required>
                            <option value="">Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="agent">Agent</option>
                            <option value="student">Student</option>
                            <option value="exhibitor">Exhibitor</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="editUserPhone" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Country</label>
                        <select name="country_id" id="editUserCountry" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Profile Image 
                            <a href="#" class="ms-2 view-avatar-link" target="_blank">(View Current Image)</a>
                        </label>
                        <input type="file" name="avatar" class="form-control">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3 col-md-6" id="editUniversityField" style="display: none;">
                        <label class="form-label">University</label>
                        <select name="university" id="editUserUniversity" class="form-control">
                            <option value="">Select University</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->name }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="editUserAddress" class="form-control" placeholder="Full Address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editUserBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    // Function to toggle university field visibility
    function toggleUniversityField(userType, isEdit = false) {
        var fieldId = isEdit ? '#editUniversityField' : '#universityField';
        if (userType === 'exhibitor') {
            $(fieldId).show();
        } else {
            $(fieldId).hide();
        }
    }

    // Initialize Select2 for add modal when it's shown
    $('#addUserModal').on('shown.bs.modal', function() {
        if ($.fn.select2) {
            // Initialize Select2 for add form
            $('select[name="user_type"]').select2({
                dropdownParent: $('#addUserModal'),
                placeholder: 'Select User Type'
            });
            $('select[name="country_id"]').select2({
                dropdownParent: $('#addUserModal'),
                placeholder: 'Select Country'
            });
            $('select[name="university"]').select2({
                dropdownParent: $('#addUserModal'),
                placeholder: 'Select University'
            });
        }
    });

    // Clean up Select2 when add modal is hidden
    $('#addUserModal').on('hidden.bs.modal', function() {
        if ($.fn.select2) {
            $('select[name="user_type"]').select2('destroy');
            $('select[name="country_id"]').select2('destroy');
            $('select[name="university"]').select2('destroy');
        }
    });

    // Handle user type change in add form
    $(document).on('change', 'select[name="user_type"]', function() {
        toggleUniversityField($(this).val(), false);
    });

    // Handle user type change in edit form
    $(document).on('change', '#editUserType', function() {
        toggleUniversityField($(this).val(), true);
    });

    $('#addUserForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#addUserForm'), "{{ route('add-new-user') }}", $('#addUserBtn'), '',
                onRequestSuccess, $('#addUserModal'));
        }
    });

    // Handle edit button click to populate modal and set avatar link
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        var countryId = $(this).data('country_id');
        var university = $(this).data('university');
        var userType = $(this).data('user_type');
        
        // Basic field population
        $('#editUserId').val(id);
        $('#editUserName').val($(this).data('name'));
        $('#editUserEmail').val($(this).data('email'));
        $('#editUserPhone').val($(this).data('phone'));
        $('#editUserAddress').val($(this).data('address'));
        
        // Set the avatar URL in the view avatar link
        var avatarPath = $(this).data('avatar');
        if (avatarPath) {
            var avatarUrl = "{{ asset('storage/') }}/" + avatarPath;
            $('.view-avatar-link').attr('href', avatarUrl).show();
        } else {
            $('.view-avatar-link').attr('href', '#').hide();
        }
        
        // Set user type first
        $('#editUserType').val(userType);
        
        // Set country value
        if (countryId) {
            $('#editUserCountry').val(countryId);
        }
        
        // Set university value
        if (university) {
            $('#editUserUniversity').val(university);
        }
        
        // Toggle university field based on user type
        toggleUniversityField(userType, true);
        
        // Use setTimeout to ensure modal is fully loaded before initializing Select2
        setTimeout(function() {
            // Destroy existing Select2 instances if they exist
            if ($.fn.select2) {
                if ($('#editUserCountry').hasClass('select2-hidden-accessible')) {
                    $('#editUserCountry').select2('destroy');
                }
                if ($('#editUserUniversity').hasClass('select2-hidden-accessible')) {
                    $('#editUserUniversity').select2('destroy');
                }
                if ($('#editUserType').hasClass('select2-hidden-accessible')) {
                    $('#editUserType').select2('destroy');
                }
                
                // Initialize Select2 for all select elements
                $('#editUserType').select2({
                    dropdownParent: $('#editUserModal'),
                    placeholder: 'Select User Type'
                });
                $('#editUserCountry').select2({
                    dropdownParent: $('#editUserModal'),
                    placeholder: 'Select Country'
                });
                $('#editUserUniversity').select2({
                    dropdownParent: $('#editUserModal'),
                    placeholder: 'Select University'
                });
                
                // Set values after Select2 initialization
                $('#editUserType').val(userType).trigger('change');
                if (countryId) {
                    $('#editUserCountry').val(countryId).trigger('change');
                }
                if (university) {
                    $('#editUserUniversity').val(university).trigger('change');
                }
            }
        }, 200);
    });

    // Clean up Select2 when edit modal is hidden
    $('#editUserModal').on('hidden.bs.modal', function() {
        if ($.fn.select2) {
            if ($('#editUserType').hasClass('select2-hidden-accessible')) {
                $('#editUserType').select2('destroy');
            }
            if ($('#editUserCountry').hasClass('select2-hidden-accessible')) {
                $('#editUserCountry').select2('destroy');
            }
            if ($('#editUserUniversity').hasClass('select2-hidden-accessible')) {
                $('#editUserUniversity').select2('destroy');
            }
        }
    });

    // Handle edit form submission
    $('#editUserForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#editUserForm'), "{{ route('update-user') }}", $('#editUserBtn'), '',
                onRequestSuccess, $('#editUserModal'));
        }
    });
</script>
@endsection