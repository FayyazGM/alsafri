<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Title-->
    <title> @yield('title')</title>
    @include('admin.includes.header')
    @yield('custom-css')
</head>

<body class="">

    @include('admin.includes.switcher')

    @include('admin/includes.loader')

    <div class="page">

        @include('admin.includes.top')

        <!--Main-Sidebar-->
        @include('admin.includes.sidebar') 
        <!-- End Main-Sidebar-->

        <!-- Start::app-content -->
        @yield('content')
        <!-- End::content  -->
        @yield('modals')
        @include('admin.includes.footer')
        <!-- End Footer -->
    </div>

    @include('admin.includes.scripts')
    @yield('custom-js')
    
    <!-- Global Report Modal -->
    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Event Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Event</label>
                        <select class="form-select" id="eventSelect">
                            <option value="">Choose an event...</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="generateReportBtn" disabled>
                            <i class="ri-file-chart-line me-2"></i> Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Load events when modal opens
        $('#generateReportModal').on('show.bs.modal', function() {
            loadEvents();
        });
        // Event select change
        $('#eventSelect').change(function() {
            $('#generateReportBtn').prop('disabled', !$(this).val());
        });
        // Generate report button click
        $('#generateReportBtn').click(function() {
            const eventId = $('#eventSelect').val();
            if (!eventId) return;
            window.location.href = '/admin/reports/event/' + eventId;
        });
    });
    function loadEvents() {
        $.ajax({
            url: '/admin/reports',
            method: 'GET',
            success: function(response) {
                const select = $('#eventSelect');
                select.find('option:not(:first)').remove();
                if (response.events && response.events.length > 0) {
                    response.events.forEach(function(event) {
                        const date = new Date(event.start_time).toLocaleDateString('en-US', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        select.append(`<option value="${event.id}">${event.name} - ${date}</option>`);
                    });
                }
            },
            error: function() {
                console.log('Error loading events');
            }
        });
    }
    </script>
</body>
</html>
