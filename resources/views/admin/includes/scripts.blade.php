<!-- SCRIPTS -->
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ti ti-arrow-narrow-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('admin_assets/libs/%40popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('admin_assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('admin_assets/libs/simplebar/simplebar.min.js') }}"></script>
    <link rel="modulepreload" href="{{ asset('admin_assets/simplebar-B35Aj-bA.js') }}" />
    <script type="module" src="{{ asset('admin_assets/simplebar-B35Aj-bA.js') }}"></script>
    <!-- Auto Complete JS -->
    <script src="{{ asset('admin_assets/libs/%40tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('admin_assets/libs/%40simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('admin_assets/libs/flatpickr/flatpickr.min.js') }}"></script>


    <!-- Apex Charts JS -->
    <script src="{{ asset('admin_assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Sales Dashboard -->
    <link rel="modulepreload" href="{{ asset('admin_assets/sales-dashboard-BU3coFtq.js') }}" />
    <script type="module" src="{{ asset('admin_assets/sales-dashboard-BU3coFtq.js') }}"></script>


    <!-- Sticky JS -->
    <script src="{{ asset('admin_assets/sticky.js') }}"></script>

    <!-- Custom-Switcher JS -->
    <link rel="modulepreload" href="{{ asset('admin_assets/custom-switcher-BayzdO2G.js') }}" />
    <script type="module" src="{{ asset('admin_assets/custom-switcher-BayzdO2G.js') }}"></script>
    <!-- APP JS-->
    <link rel="modulepreload" href="{{ asset('admin_assets/app-C4M4tSMb.js') }}" />
    <script type="module" src="{{ asset('admin_assets/app-C4M4tSMb.js') }}"></script>
    <!-- END SCRIPTS -->

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        {{-- Custom Js --}}
        <script src="{{asset('admin_assets/js/script.js')}}"></script>
        <script src="{{asset('admin_assets/js/validate.min.js')}}"></script>
        <script src="{{asset('admin_assets/libs/select2/js/select2.min.js')}}"></script>
        <script>
    $(document).ready(function () {
        $('select').each(function () {
            const $select = $(this);
            const $modalParent = $select.closest('.modal');
            
            // Skip Select2 initialization for city selects on manage-events page
            if ($select.is('#citySelect') || $select.is('#editCitySelect') || $select.hasClass('city-select')) {
                return;
            }

            $select.select2({
                dropdownParent: $modalParent.length ? $modalParent : $(document.body)
            });
        });
    });
</script>
