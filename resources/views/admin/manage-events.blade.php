@extends('admin.layout.index')
@section('title', 'Manage Events')


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
                    <li class="breadcrumb-item active" aria-current="page">Events</li>
                </ol>
                <h1 class="page-title fw-medium fs-18 mb-0">Manage Events</h1>
            </div>
            <div>
                <button class="btn btn-primary rounded-pill btn-wave shadow-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="ri-add-line align-bottom"></i> Add Event
                </button>
                <a href="{{ route('import-attendees-form') }}" class="btn btn-success rounded-pill btn-wave shadow-success ms-2">
                    <i class="ri-upload-line align-bottom"></i> Import Attendees
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="eventList">
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form action="">
                            <div class="row g-3">
                                <div class="col-xl-10">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search by event name or description..." value="{{ $filter }}" name="filter">
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
                            <table class="table table-bordered nowrap table-striped align-middle" style="width:100%;min-height:200px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Event Name</th>
                                        <th>Description</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($events) > 0)
                                        @foreach ($events as $event)
                                            <tr>
                                                <td>{{ ($events->currentPage() - 1) * $events->perPage() + $loop->index + 1 }}</td>
                                                <td>{{ $event->name }} 
                                                    @if($event->event_type == 'virtual')
                                                        <span class="badge bg-info">Virtual</span>
                                                    @else
                                                        <span class="badge bg-secondary">Physical</span>
                                                    @endif
                                                </td>
                                                <td>{{ Str::limit($event->description, 50) }}</td>
                                                <td>{{ $event->start_time->format('d M Y, h:i A') }}</td>
                                                <td>{{ $event->end_time ? $event->end_time->format('d M Y, h:i A') : 'N/A' }}</td>
                                                <td>
                                                    @if($event->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                      <button class="btn btn-icon rounded-pill btn-primary btn-wave shadow-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" style="">
                                                        <li>  
                                                            <button
                                                            class="dropdown-item editBtn"
                                                            data-id="{{ $event->id }}"
                                                            data-name="{{ $event->name }}"
                                                            data-description="{{ $event->description }}"
                                                            data-start_time="{{ $event->start_time->format('Y-m-d\TH:i') }}"
                                                            data-end_time="{{ $event->end_time ? $event->end_time->format('Y-m-d\TH:i') : '' }}"
                                                            data-is_active="{{ $event->is_active }}"
                                                            data-auto_approval="{{ $event->auto_approval }}"
                                                            data-location="{{ $event->location }}"
                                                            data-organized_by="{{ $event->organized_by }}"
                                                            data-city_id="{{ $event->city_id }}"
                                                            data-event_type="{{ $event->event_type }}"
                                                            data-zoom_link="{{ $event->zoom_link }}"
                                                            data-qrcode_image="{{ $event->qrcode_image }}"
                                                            {{-- data-google_map_iframe="{{ $event->google_map_iframe }}" --}}
                                                            data-slider_image="{{ $event->slider_image }}"
                                                            data-main_image="{{ $event->main_image }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editEventModal"
                                                        >
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </button>
                                                        </li>
                                                        <li>
                                                            <a
                                                            href="{{ route('registration-form-view' , $event->id) }}"
                                                            class="dropdown-item editBtn">
                                                            <i class="uil uil-apps"></i>
                                                                Registration Form
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a
                                                            href="{{ route('event-attendees' , $event->id) }}"
                                                            class="dropdown-item editBtn">
                                                            <i class="uil uil-users-alt"></i>
                                                                Event Attendees
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a
                                                            href="{{ route('event-gallery' , $event->id) }}"
                                                            class="dropdown-item">
                                                            <i class="uil uil-image"></i>
                                                                Event Gallery
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button
                                                            class="dropdown-item linkExhibitorsBtn"
                                                            data-id="{{ $event->id }}"
                                                            data-name="{{ $event->name }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#linkExhibitorsModal">
                                                            <i class="uil uil-link"></i>
                                                                Link Exhibitors
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No Events Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $events->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('modals')
<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="addEventForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Event Type</label>
                        <select name="event_type" id="eventType" class="form-control" required>
                            <option value="physical" selected>Physical</option>
                            <option value="virtual">Virtual</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Event Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Event Name" required>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Event Description" required></textarea>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">End Time </label>
                        <input type="datetime-local" name="end_time" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Slider Image ( 1189 x 783px ) <a href="/assets/img/all-images/hero/hero-img2.png" target="_blank"> Reference </a> </label>
                        <input type="file" name="slider_image" class="form-control" required="">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Main Image ( 620 x 420px ) <a href="/assets/img/all-images/event/event-img8.png" target="_blank"> Reference </a></label>
                        <input type="file" name="main_image" class="form-control" required="">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">City</label>
                        <select name="city_id" id="citySelect" class="form-control" required>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" data-province="{{ $city->province }}">{{ $city->name }}, {{ $city->province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Location (Additional Details)</label>
                        <input type="text" name="location" class="form-control" placeholder="Specific venue or address">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Organized By</label>
                        <input type="text" name="organized_by" class="form-control" placeholder="Organized By">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Google Map Iframe Code (Optional)</label>
                        <textarea name="google_map_iframe" class="form-control" placeholder="Paste Google Map iframe code here"></textarea>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Slider Images (Multiple Allowed) Detail Page</label>
                        <input type="file" name="slider_images[]" class="form-control" multiple>
                        <div id="sliderImagesPreview" class="mt-2"></div>
                    </div>
                    <!-- Lineups Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Lineups</label>
                        <div class="row mb-2">
                            <div class="col-md-1"><label class="form-label small">Sort</label></div>
                            <div class="col-md-5"><label class="form-label small">Name</label></div>
                            <div class="col-md-5"><label class="form-label small">Image</label></div>
                            <div class="col-md-1"><label class="form-label small">Action</label></div>
                        </div>
                        <div id="lineupsContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addLineupBtn">Add Lineup</button>
                    </div>
                    <!-- Agenda Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Agenda</label>
                        <div class="row mb-2">
                            <div class="col-md-1"><label class="form-label small">Sort</label></div>
                            <div class="col-md-2"><label class="form-label small">Start Time</label></div>
                            <div class="col-md-2"><label class="form-label small">End Time</label></div>
                            <div class="col-md-2"><label class="form-label small">Title</label></div>
                            <div class="col-md-2"><label class="form-label small">Username</label></div>
                            <div class="col-md-2"><label class="form-label small">User Image</label></div>
                            <div class="col-md-1"><label class="form-label small">Action</label></div>
                        </div>
                        <div id="agendaContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addAgendaBtn">Add Agenda Item</button>
                    </div>
                    <!-- FAQs Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">FAQs</label>
                        <div id="faqsContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addFaqBtn">Add FAQ</button>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="auto_approval" id="autoApproval" value="1">
                            <label class="form-check-label" for="autoApproval">Auto Approval</label>
                        </div>
                    </div>
                    
                    <div class="mb-3 col-md-12 d-none" id="virtualFields">
                        <label class="form-label">Zoom Link</label>
                        <input type="url" name="zoom_link" id="zoomLink" class="form-control" placeholder="Zoom Meeting Link">
                        <label class="form-label mt-2">QR Code Image</label>
                        <input type="file" name="qrcode_image" id="qrcodeImage" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="addEventBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="editEventForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="editEventId">
                
                    <div class="modal-body row">
                        <div class="mb-3 col-md-12">
                        <label class="form-label">Event Type</label>
                        <select name="event_type" id="editEventType" class="form-control" required>
                            <option value="physical">Physical</option>
                            <option value="virtual">Virtual</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-12 d-none" id="editVirtualFields">
                        <label class="form-label">Zoom Link</label>
                        <input type="url" name="zoom_link" id="editZoomLink" class="form-control" placeholder="Zoom Meeting Link">
                        <label class="form-label mt-2">QR Code Image</label>
                        <input type="file" name="qrcode_image" id="editQrcodeImage" class="form-control">
                        <div id="editQrcodeImagePreview" class="mt-2"></div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Event Name</label>
                        <input type="text" name="name" id="editEventName" class="form-control" placeholder="Event Name" required>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editEventDescription" class="form-control" placeholder="Event Description"></textarea>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" id="editEventStartTime" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">End Time (Optional)</label>
                        <input type="datetime-local" name="end_time" id="editEventEndTime" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Slider Image 
                            <a href="#" class="ms-2 view-slider-image-link" target="_blank">(View Current Image)</a>
                        </label>
                        <input type="file" name="slider_image" class="form-control">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Main Image 
                            <a href="#" class="ms-2 view-main-image-link" target="_blank">(View Current Image)</a>
                        </label>
                        <input type="file" name="main_image" class="form-control">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">City</label>
                        <select name="city_id" id="editCitySelect" class="form-select city-select" required>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" data-province="{{ $city->province }}">{{ $city->name }}, {{ $city->province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Location (Additional Details)</label>
                        <input type="text" name="location" id="editEventLocation" class="form-control" placeholder="Specific venue or address">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Organized By</label>
                        <input type="text" name="organized_by" id="editEventOrganizedBy" class="form-control" placeholder="Organized By">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Google Map Iframe Code (Optional) <small>Leave it blank if you don't want to edit</small> </label>
                        <textarea name="google_map_iframe" id="editEventGoogleMap" class="form-control" placeholder="Paste Google Map iframe code here"></textarea>
                    </div>
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive" value="1">
                            <label class="form-check-label" for="editIsActive">Active</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="auto_approval" id="editAutoApproval" value="1">
                            <label class="form-check-label" for="editAutoApproval">Auto Approval</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Slider Images (Multiple Allowed) Event Detail</label>
                        <input type="file" name="slider_images[]" id="editSliderImages" class="form-control" multiple>
                        <div id="editSliderImagesPreview" class="mt-2"></div>
                    </div>
                    <!-- Lineups Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Lineups</label>
                        <div class="row mb-2">
                            <div class="col-md-1"><label class="form-label small">Sort</label></div>
                            <div class="col-md-5"><label class="form-label small">Name</label></div>
                            <div class="col-md-5"><label class="form-label small">Image</label></div>
                            <div class="col-md-1"><label class="form-label small">Action</label></div>
                        </div>
                        <div id="editLineupsContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="editAddLineupBtn">Add Lineup</button>
                    </div>
                    <!-- Agenda Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Agenda</label>
                        <div class="row mb-2">
                            <div class="col-md-1"><label class="form-label small">Sort</label></div>
                            <div class="col-md-2"><label class="form-label small">Start Time</label></div>
                            <div class="col-md-2"><label class="form-label small">End Time</label></div>
                            <div class="col-md-2"><label class="form-label small">Title</label></div>
                            <div class="col-md-2"><label class="form-label small">Username</label></div>
                            <div class="col-md-2"><label class="form-label small">User Image</label></div>
                            <div class="col-md-1"><label class="form-label small">Action</label></div>
                        </div>
                        <div id="editAgendaContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="editAddAgendaBtn">Add Agenda Item</button>
                    </div>
                    <!-- FAQs Section -->
                    <div class="mb-3 col-md-12">
                        <label class="form-label">FAQs</label>
                        <div id="editFaqsContainer"></div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="editAddFaqBtn">Add FAQ</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-pill btn-wave shadow-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editEventBtn" class="btn btn-primary rounded-pill btn-wave shadow-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Link Exhibitors Modal -->
<div class="modal fade" id="linkExhibitorsModal" tabindex="-1" aria-labelledby="linkExhibitorsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkExhibitorsModalLabel">Link Exhibitors to Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="linkExhibitorsForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="linkEventId" name="event_id">
                    <div class="mb-3">
                        <label class="form-label">Event Name</label>
                        <input type="text" id="linkEventName" class="form-control" readonly>
                    </div>
                    
                    <!-- Already Linked Exhibitors -->
                    <div class="mb-4">
                        <h6 class="text-primary">Currently Linked Exhibitors</h6>
                        <div id="linkedExhibitorsList" class="border rounded p-3" style="min-height: 100px;">
                            <div class="text-center text-muted">
                                <i class="uil uil-spinner-alt uil-spin"></i> Loading...
                            </div>
                        </div>
                    </div>
                    
                    <!-- Available Exhibitors -->
                    <div class="mb-3">
                        <label class="form-label">Select Exhibitors to Link</label>
                        <select name="exhibitors[]" id="exhibitorsSelect" class="form-control" multiple style="height: 200px;">
                            @foreach($exhibitors as $exhibitor)
                                <option value="{{ $exhibitor->id }}">{{ $exhibitor->name }} ({{ $exhibitor->university ?? 'No University' }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple exhibitors</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="linkExhibitorsBtn" class="btn btn-primary">Link Exhibitors</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('custom-js')
<script>
$(function() {
    
    // Store original exhibitors data globally
    var originalExhibitors = [];
    
    // Initialize original exhibitors data
    $('#exhibitorsSelect option').each(function() {
        if ($(this).val() !== '') {
            originalExhibitors.push({
                id: $(this).val(),
                text: $(this).text()
            });
        }
    });
    
    $('#addEventForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#addEventForm'), "{{ route('add-new-event') }}", $('#addEventBtn'), '',
                onRequestSuccess, $('#addEventModal'));
        }
    });

    // Handle edit button click to populate modal and set image links
    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $('#editEventId').val(id);
        $('#editEventName').val($(this).data('name'));
        $('#editEventDescription').val($(this).data('description'));
        $('#editEventStartTime').val($(this).data('start_time'));
        $('#editEventEndTime').val($(this).data('end_time'));
        $('#editEventLocation').val($(this).data('location'));
        $('#editEventOrganizedBy').val($(this).data('organized_by'));
        
        // Set city value using simple select
        var cityId = $(this).data('city_id');
        $('#editCitySelect').val(cityId);
        
        $('#editIsActive').prop('checked', $(this).data('is_active'));
        $('#editAutoApproval').prop('checked', $(this).data('auto_approval'));
        
        
        // Set the slider image URL
        var sliderImagePath = $(this).data('slider_image');
        if (sliderImagePath) {
            var sliderImageUrl = "{{ asset('storage/') }}/" + sliderImagePath;
            $('.view-slider-image-link').attr('href', sliderImageUrl).show();
        } else {
            $('.view-slider-image-link').attr('href', '#').hide();
        }
        
        // Set the main image URL
        var mainImagePath = $(this).data('main_image');
        if (mainImagePath) {
            var mainImageUrl = "{{ asset('storage/') }}/" + mainImagePath;
            $('.view-main-image-link').attr('href', mainImageUrl).show();
        } else {
            $('.view-main-image-link').attr('href', '#').hide();
        }
    });

    // Handle edit form submission
    $('#editEventForm').validate({
        submitHandler: function() {
            'use strict';
            handleAjaxCall($('#editEventForm'), "{{ route('update-event') }}", $('#editEventBtn'), '',
                onRequestSuccess, $('#editEventModal'));
        }
    });

    // Toggle virtual fields
    $('#eventType').on('change', function() {
        if ($(this).val() === 'virtual') {
            $('#virtualFields').removeClass('d-none');
            $('#zoomLink').attr('required', true);
            $('#qrcodeImage').attr('required', true);
        } else {
            $('#virtualFields').addClass('d-none');
            $('#zoomLink').removeAttr('required');
            $('#qrcodeImage').removeAttr('required');
        }
    });
    // On page load, ensure correct state
    if ($('#eventType').val() === 'virtual') {
        $('#virtualFields').removeClass('d-none');
        $('#zoomLink').attr('required', true);
        $('#qrcodeImage').attr('required', true);
    }

    // Toggle virtual fields in edit modal
    $('#editEventType').on('change', function() {
        if ($(this).val() === 'virtual') {
            $('#editVirtualFields').removeClass('d-none');
            $('#editZoomLink').attr('required', true);
            $('#editQrcodeImage').attr('required', false); // Not required on edit
        } else {
            $('#editVirtualFields').addClass('d-none');
            $('#editZoomLink').removeAttr('required');
            $('#editQrcodeImage').removeAttr('required');
        }
    });
    // On edit modal open, set event type and show/hide fields
    $(document).on('click', '.editBtn', function() {
        $('#editEventType').val($(this).data('event_type') || 'physical').trigger('change');
        $('#editZoomLink').val($(this).data('zoom_link') || '');
        var qrcodeImagePath = $(this).data('qrcode_image');
        if(qrcodeImagePath) {
            var qrcodeImageUrl = "{{ asset('storage/') }}/" + qrcodeImagePath;
            $('#editQrcodeImagePreview').html('<img src="'+qrcodeImageUrl+'" style="max-width:100px;max-height:80px;">');
        } else {
            $('#editQrcodeImagePreview').html('');
        }
    });

    // Handle exhibitor linking modal
    $(document).on('click', '.linkExhibitorsBtn', function() {
        var eventId = $(this).data('id');
        var eventName = $(this).data('name');
        
        // Reset the form completely
        $('#linkExhibitorsForm')[0].reset();
        
        $('#linkEventId').val(eventId);
        $('#linkEventName').val(eventName);
        
        // Load linked exhibitors
        loadLinkedExhibitors(eventId);
        
        // Clear previous selections
        $('#exhibitorsSelect').val([]);
    });

    // Load linked exhibitors for an event
    function loadLinkedExhibitors(eventId) {
        $('#linkedExhibitorsList').html('<div class="text-center text-muted"><i class="uil uil-spinner-alt uil-spin"></i> Loading...</div>');
        
        $.get('/admin/events/' + eventId + '/exhibitors', function(data) {
            if (data.success && data.exhibitors.length > 0) {
                var html = '';
                var linkedExhibitorIds = [];
                
                data.exhibitors.forEach(function(exhibitor) {
                    linkedExhibitorIds.push(exhibitor.id);
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>${exhibitor.name}</strong>
                                <small class="text-muted d-block">${exhibitor.university || 'No University'}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger unlinkExhibitorBtn" data-exhibitor-id="${exhibitor.id}">
                                <i class="uil uil-times"></i> Unlink
                            </button>
                        </div>
                    `;
                });
                $('#linkedExhibitorsList').html(html);
                
                // Hide already linked exhibitors from the dropdown
                filterAvailableExhibitors(linkedExhibitorIds);
            } else {
                $('#linkedExhibitorsList').html('<div class="text-center text-muted">No exhibitors linked to this event</div>');
                // Show all exhibitors if none are linked
                filterAvailableExhibitors([]);
            }
        }).fail(function() {
            $('#linkedExhibitorsList').html('<div class="text-center text-danger">Error loading exhibitors</div>');
        });
    }
    
    // Filter available exhibitors in the dropdown
    function filterAvailableExhibitors(linkedExhibitorIds) {
        // Clear the select and rebuild with only available exhibitors
        $('#exhibitorsSelect').empty();
        
        // Add available exhibitors (not linked) from original data
        originalExhibitors.forEach(function(exhibitor) {
            if (!linkedExhibitorIds.includes(parseInt(exhibitor.id))) {
                $('#exhibitorsSelect').append(new Option(exhibitor.text, exhibitor.id));
            }
        });
    }

    // Handle unlink exhibitor
    $(document).on('click', '.unlinkExhibitorBtn', function() {
        var exhibitorId = $(this).data('exhibitor-id');
        var eventId = $('#linkEventId').val();
        
        if (confirm('Are you sure you want to unlink this exhibitor?')) {
            $.ajax({
                url: '/admin/events/unlink-exhibitor',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    event_id: eventId,
                    exhibitor_id: exhibitorId
                },
                success: function(response) {
                    if (response.success) {
                        loadLinkedExhibitors(eventId);
                        alertMessage(response.message, false);
                    } else {
                        alertMessage(response.message, true);
                    }
                },
                error: function() {
                    alertMessage('Error unlinking exhibitor', true);
                }
            });
        }
    });

    // Handle link exhibitors form submission
    $('#linkExhibitorsForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var eventId = $('#linkEventId').val();
        
        $('#linkExhibitorsBtn').prop('disabled', true).html('<i class="uil uil-spinner-alt uil-spin"></i> Linking...');
        
        $.ajax({
            url: '/admin/events/link-exhibitors',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    $('#linkExhibitorsModal').modal('hide');
                    
                    // Show success message
                    alertMessage(response.message, false);
                    
                    // Reload the page after a short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alertMessage(response.message, true);
                }
            },
            error: function() {
                alertMessage('Error linking exhibitors', true);
            },
            complete: function() {
                $('#linkExhibitorsBtn').prop('disabled', false).html('Link Exhibitors');
            }
        });
    });


    // Reset form when Link Exhibitors modal is shown
    $('#linkExhibitorsModal').on('show.bs.modal', function() {
        $('#linkExhibitorsForm')[0].reset();
        $('#linkedExhibitorsList').html('<div class="text-center text-muted"><i class="uil uil-spinner-alt uil-spin"></i> Loading...</div>');
        // Restore all exhibitors initially
        restoreAllExhibitors();
    });
    
    // Function to restore all exhibitors in the dropdown
    function restoreAllExhibitors() {
        // Clear and rebuild with all exhibitors from global data
        $('#exhibitorsSelect').empty();
        originalExhibitors.forEach(function(exhibitor) {
            $('#exhibitorsSelect').append(new Option(exhibitor.text, exhibitor.id));
        });
    }
    
    // Reset form when add modal is opened
    $('#addEventModal').on('show.bs.modal', function() {
        $('#addEventForm')[0].reset();
    });
    
});
</script>
<script>
// --- Slider Images Preview ---
$(document).on('change', 'input[name="slider_images[]"]', function(e) {
    let files = e.target.files;
    let preview = $('#sliderImagesPreview');
    preview.html('');
    if (files) {
        Array.from(files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.append('<img src="'+e.target.result+'" class="me-2 mb-2" style="max-width:100px;max-height:80px;">');
            }
            reader.readAsDataURL(file);
        });
    }
});
// --- Dynamic Lineups ---
let lineupIndex = 0;
$('#addLineupBtn').on('click', function(e) {
    e.preventDefault();
    $('#lineupsContainer').append(`
        <div class="row lineup-item mb-2" data-index="${lineupIndex}">
            <div class="col-md-1"><input type="number" name="lineups[${lineupIndex}][sort]" class="form-control" placeholder="Sort" value="${lineupIndex + 1}" min="1"></div>
            <div class="col-md-5"><input type="text" name="lineups[${lineupIndex}][name]" class="form-control" placeholder="Lineup Name" required></div>
            <div class="col-md-5"><input type="file" name="lineups[${lineupIndex}][image]" class="form-control" required></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-lineup">Remove</button></div>
        </div>
    `);
    lineupIndex++;
});
$(document).on('click', '.remove-lineup', function() {
    $(this).closest('.lineup-item').remove();
});
// --- Dynamic Agenda ---
let agendaIndex = 0;
$('#addAgendaBtn').on('click', function(e) {
    e.preventDefault();
    $('#agendaContainer').append(`
        <div class="row agenda-item mb-2" data-index="${agendaIndex}">
            <div class="col-md-1"><input type="number" name="agenda[${agendaIndex}][sort]" class="form-control" placeholder="Sort" value="${agendaIndex + 1}" min="1"></div>
            <div class="col-md-2"><input type="text" name="agenda[${agendaIndex}][start_time]" class="form-control" placeholder="Start Time (e.g. 4:00 PM)" required></div>
            <div class="col-md-2"><input type="text" name="agenda[${agendaIndex}][end_time]" class="form-control" placeholder="End Time (e.g. 4:30 PM)"></div>
            <div class="col-md-2"><input type="text" name="agenda[${agendaIndex}][title]" class="form-control" placeholder="Title" required></div>
            <div class="col-md-2"><input type="text" name="agenda[${agendaIndex}][username]" class="form-control" placeholder="Person Name"></div>
            <div class="col-md-2"><input type="file" name="agenda[${agendaIndex}][user_image]" class="form-control"></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-agenda">Remove</button></div>
            <div class="col-md-12 mt-1"><textarea name="agenda[${agendaIndex}][description]" class="form-control" placeholder="Description"></textarea></div>
        </div>
    `);
    agendaIndex++;
});
$(document).on('click', '.remove-agenda', function() {
    $(this).closest('.agenda-item').remove();
});
// --- Dynamic FAQs ---
let faqIndex = 0;
$('#addFaqBtn').on('click', function(e) {
    e.preventDefault();
    $('#faqsContainer').append(`
        <div class="row faq-item mb-2" data-index="${faqIndex}">
            <div class="col-md-5"><input type="text" name="faqs[${faqIndex}][question]" class="form-control" placeholder="Question" required></div>
            <div class="col-md-5"><input type="text" name="faqs[${faqIndex}][answer]" class="form-control" placeholder="Answer" required></div>
            <div class="col-md-2"><button type="button" class="btn btn-danger btn-sm remove-faq">Remove</button></div>
        </div>
    `);
    faqIndex++;
});
$(document).on('click', '.remove-faq', function() {
    $(this).closest('.faq-item').remove();
});
// --- Dynamic Edit Lineups ---
let editLineupIndex = 0;
$('#editAddLineupBtn').on('click', function(e) {
    e.preventDefault();
    $('#editLineupsContainer').append(`
        <div class="row lineup-item mb-2" data-index="${editLineupIndex}">
            <div class="col-md-1"><input type="number" name="lineups[${editLineupIndex}][sort]" class="form-control" placeholder="Sort" value="${editLineupIndex + 1}" min="1"></div>
            <div class="col-md-5"><input type="text" name="lineups[${editLineupIndex}][name]" class="form-control" placeholder="Lineup Name" required></div>
            <div class="col-md-5"><input type="file" name="lineups[${editLineupIndex}][image]" class="form-control"></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-lineup">Remove</button></div>
        </div>
    `);
    editLineupIndex++;
});
$(document).on('click', '.remove-lineup', function() {
    $(this).closest('.lineup-item').remove();
});
// --- Dynamic Edit Agenda ---
let editAgendaIndex = 0;
$('#editAddAgendaBtn').on('click', function(e) {
    e.preventDefault();
    $('#editAgendaContainer').append(`
        <div class="row agenda-item mb-2" data-index="${editAgendaIndex}">
            <div class="col-md-1"><label>Sort</label><input type="number" name="agenda[${editAgendaIndex}][sort]" class="form-control" placeholder="Sort" value="${editAgendaIndex + 1}" min="1"></div>
            <div class="col-md-2"><label>Start Time</label><input type="text" name="agenda[${editAgendaIndex}][start_time]" class="form-control" placeholder="Start Time (e.g. 4:00 PM)" required></div>
            <div class="col-md-2"><label>End Time</label><input type="text" name="agenda[${editAgendaIndex}][end_time]" class="form-control" placeholder="End Time (e.g. 4:30 PM)"></div>
            <div class="col-md-2"><label>Title</label><input type="text" name="agenda[${editAgendaIndex}][title]" class="form-control" placeholder="Title" required></div>
            <div class="col-md-2"><label>Username</label><input type="text" name="agenda[${editAgendaIndex}][username]" class="form-control" placeholder="Person Name"></div>
            <div class="col-md-2"><label>User Image</label><input type="file" name="agenda[${editAgendaIndex}][user_image]" class="form-control"></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-agenda">Remove</button></div>
            <div class="col-md-12 mt-1"><label>Description</label><textarea name="agenda[${editAgendaIndex}][description]" class="form-control" placeholder="Description"></textarea></div>
        </div>
    `);
    editAgendaIndex++;
});
$(document).on('click', '.remove-agenda', function() {
    $(this).closest('.agenda-item').remove();
});
// --- Dynamic Edit FAQs ---
let editFaqIndex = 0;
$('#editAddFaqBtn').on('click', function(e) {
    e.preventDefault();
    $('#editFaqsContainer').append(`
        <div class="row faq-item mb-2" data-index="${editFaqIndex}">
            <div class="col-md-5"><input type="text" name="faqs[${editFaqIndex}][question]" class="form-control" placeholder="Question" required></div>
            <div class="col-md-5"><input type="text" name="faqs[${editFaqIndex}][answer]" class="form-control" placeholder="Answer" required></div>
            <div class="col-md-2"><button type="button" class="btn btn-danger btn-sm remove-faq">Remove</button></div>
        </div>
    `);
    editFaqIndex++;
});
$(document).on('click', '.remove-faq', function() {
    $(this).closest('.faq-item').remove();
});
// --- Populate Edit Modal with Event Data ---
$(document).on('click', '.editBtn', function() {
    var id = $(this).data('id');
    // Clear containers and reset indexes
    $('#editLineupsContainer').html(''); editLineupIndex = 0;
    $('#editAgendaContainer').html(''); editAgendaIndex = 0;
    $('#editFaqsContainer').html(''); editFaqIndex = 0;
    $('#editSliderImagesPreview').html('');
    // Fetch event data via AJAX
    $.get('/admin/events/' + id + '/edit-data', function(data) {
        // Populate lineups
        if(data.lineups) {
            data.lineups.forEach(function(lineup, i) {
                $('#editLineupsContainer').append(`
                    <div class="row lineup-item mb-2" data-index="${editLineupIndex}">
                        <div class="col-md-1"><input type="number" name="lineups[${editLineupIndex}][sort]" class="form-control" value="${lineup.sort || editLineupIndex + 1}" placeholder="Sort" min="1"></div>
                        <div class="col-md-5"><input type="text" name="lineups[${editLineupIndex}][name]" class="form-control" value="${lineup.name}" placeholder="Lineup Name" required></div>
                        <div class="col-md-5"><input type="file" name="lineups[${editLineupIndex}][image]" class="form-control"><small class="text-muted">Leave empty to keep current image</small></div>
                        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-lineup">Remove</button></div>
                    </div>
                `);
                editLineupIndex++;
            });
        }
        // Populate agenda
        if(data.agendas) {
            data.agendas.forEach(function(agenda, i) {
                $('#editAgendaContainer').append(`
                    <div class="row agenda-item mb-2" data-index="${editAgendaIndex}">
                        <div class="col-md-1"><label>Sort</label><input type="number" name="agenda[${editAgendaIndex}][sort]" class="form-control" value="${agenda.sort || editAgendaIndex + 1}" placeholder="Sort" min="1"></div>
                        <div class="col-md-2"><label>Start Time</label><input type="text" name="agenda[${editAgendaIndex}][start_time]" class="form-control" value="${agenda.start_time}" placeholder="Start Time (e.g. 4:00 PM)" required></div>
                        <div class="col-md-2"><label>End Time</label><input type="text" name="agenda[${editAgendaIndex}][end_time]" class="form-control" value="${agenda.end_time}" placeholder="End Time (e.g. 4:30 PM)"></div>
                        <div class="col-md-2"><label>Title</label><input type="text" name="agenda[${editAgendaIndex}][title]" class="form-control" value="${agenda.title}" placeholder="Title" required></div>
                        <div class="col-md-2"><label>Username</label><input type="text" name="agenda[${editAgendaIndex}][username]" class="form-control" value="${agenda.username}" placeholder="Username"></div>
                        <div class="col-md-2"><label>User Image</label><input type="file" name="agenda[${editAgendaIndex}][user_image]" class="form-control"><small class="text-muted">Leave empty to keep current image</small></div>
                        <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-agenda">Remove</button></div>
                        <div class="col-md-12 mt-1"><label>Description</label><textarea name="agenda[${editAgendaIndex}][description]" class="form-control" placeholder="Description">${agenda.description || ''}</textarea></div>
                    </div>
                `);
                editAgendaIndex++;
            });
        }
        // Populate faqs
        if(data.faqs) {
            data.faqs.forEach(function(faq, i) {
                $('#editFaqsContainer').append(`
                    <div class="row faq-item mb-2" data-index="${editFaqIndex}">
                        <div class="col-md-5"><input type="text" name="faqs[${editFaqIndex}][question]" class="form-control" value="${faq.question}" placeholder="Question" required></div>
                        <div class="col-md-5"><input type="text" name="faqs[${editFaqIndex}][answer]" class="form-control" value="${faq.answer}" placeholder="Answer" required></div>
                        <div class="col-md-2"><button type="button" class="btn btn-danger btn-sm remove-faq">Remove</button></div>
                    </div>
                `);
                editFaqIndex++;
            });
        }
        // Populate slider images preview
        if(data.slider_images) {
            data.slider_images.forEach(function(img) {
                $('#editSliderImagesPreview').append(`
                    <div class="slider-image-preview-item d-inline-block position-relative me-2 mb-2" data-id="${img.id}">
                        <img src="/storage/${img.image_path}" style="max-width:100px;max-height:80px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-slider-image-btn" data-id="${img.id}">&times;</button>
                    </div>
                `);
            });
        }
    });
});
// Add click handler for delete-slider-image-btn
$(document).on('click', '.delete-slider-image-btn', function() {
    var imgId = $(this).data('id');
    var $imgDiv = $(this).closest('.slider-image-preview-item');
    if(confirm('Are you sure you want to delete this slider image?')) {
        $.ajax({
            url: '/admin/events/slider-image/' + imgId + '/delete',
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                if(res.success) {
                    $imgDiv.remove();
                } else {
                    alert(res.message || 'Failed to delete image.');
                }
            },
            error: function() {
                alert('Failed to delete image.');
            }
        });
    }
});
</script>
@endsection