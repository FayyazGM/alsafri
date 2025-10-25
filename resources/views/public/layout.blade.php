<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title')</title>
    
     @include('public.includes.header')
</head>
<body>

    @include('public.includes.loader')

<!--=====HEADER START=======-->
    @include('public.includes.navbar')
 <!--=====HEADER END =======-->

<!--===== MOBILE HEADER STARTS =======-->
    @include('public.includes.mobile-navbar')
<!--===== MOBILE HEADER STARTS =======-->

    @yield('content')
    
    <!--===== FOOTER AREA STARTS =======-->
    @include('public.includes.footer')
    <!--===== FOOTER AREA ENDS =======-->
    
    <!--===== SIDEBAR STARTS=======-->
    @include('public.includes.rightbar-search')
    <!--===== SIDEBAR ENDS STARTS=======-->
    
    <!--===== SIDEBAR STARTS=======-->
    @include('public.includes.rightbar')
    <!--===== SIDEBAR ENDS STARTS=======-->
    
    <!--===== JS SCRIPT LINK =======-->
    @include('public.includes.scripts')
    
    <!-- Google Translate Widget -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            try {
                // Desktop widget
                if (document.getElementById('google_translate_element')) {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,ar',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false,
                        multilanguagePage: true
                    }, 'google_translate_element');
                }
                
                // Mobile widget
                if (document.getElementById('google_translate_element_mobile')) {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,ar',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false,
                        multilanguagePage: true
                    }, 'google_translate_element_mobile');
                }
                
                // Listen for language changes to handle RTL/LTR
                setupDirectionHandling();
                
            } catch (error) {
                console.log('Google Translate initialization error:', error);
            }
        }
        
        // Function to handle RTL/LTR direction changes
        function setupDirectionHandling() {
            // Method 1: Listen for Google Translate language changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const target = mutation.target;
                        if (target.classList.contains('translated-ltr') || target.classList.contains('translated-rtl')) {
                            handleDirectionChange(target);
                        }
                    }
                });
            });
            
            // Start observing the body for class changes
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
            
            // Method 2: Listen for Google Translate dropdown changes
            const translateObserver = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        // Check if Google Translate has changed the language
                        checkCurrentLanguage();
                    }
                });
            });
            
            // Observe the entire document for changes
            translateObserver.observe(document.documentElement, {
                childList: true,
                subtree: true
            });
            
            // Method 3: Periodic check for language changes
            setInterval(checkCurrentLanguage, 2000);
            
            // Initial check
            setTimeout(checkCurrentLanguage, 1000);
        }
        
        // Function to check current language and apply direction
        function checkCurrentLanguage() {
            // Check if Google Translate has set any language
            const bodyClasses = document.body.className;
            const htmlClasses = document.documentElement.className;
            
            console.log('Checking language - Body classes:', bodyClasses);
            console.log('Checking language - HTML classes:', htmlClasses);
            
            // Look for Google Translate indicators
            if (bodyClasses.includes('translated-rtl') || htmlClasses.includes('translated-rtl')) {
                console.log('Google Translate RTL detected');
                applyRTL();
            } else if (bodyClasses.includes('translated-ltr') || htmlClasses.includes('translated-ltr')) {
                console.log('Google Translate LTR detected');
                applyLTR();
            } else {
                // Default to LTR (English) unless explicitly translated to Arabic
                console.log('No Google Translate classes found, defaulting to LTR');
                applyLTR();
            }
        }
        
        // Apply RTL direction
        function applyRTL() {
            if (!document.documentElement.getAttribute('dir') || document.documentElement.getAttribute('dir') !== 'rtl') {
                document.documentElement.setAttribute('dir', 'rtl');
                document.documentElement.setAttribute('lang', 'ar');
                document.body.classList.add('rtl');
                document.body.classList.remove('ltr');
                console.log('RTL direction applied for Arabic');
            }
        }
        
        // Apply LTR direction
        function applyLTR() {
            if (!document.documentElement.getAttribute('dir') || document.documentElement.getAttribute('dir') !== 'ltr') {
                document.documentElement.setAttribute('dir', 'ltr');
                document.documentElement.setAttribute('lang', 'en');
                document.body.classList.add('ltr');
                document.body.classList.remove('rtl');
                console.log('LTR direction applied for English');
            }
        }
        
        // Handle direction change
        function handleDirectionChange(element) {
            if (element.classList.contains('translated-rtl')) {
                // Arabic selected - apply RTL styles
                document.documentElement.setAttribute('dir', 'rtl');
                document.documentElement.setAttribute('lang', 'ar');
                document.body.classList.add('rtl');
                console.log('RTL direction applied for Arabic');
            } else if (element.classList.contains('translated-ltr')) {
                // English selected - apply LTR styles
                document.documentElement.setAttribute('dir', 'ltr');
                document.documentElement.setAttribute('lang', 'en');
                document.body.classList.remove('rtl');
                console.log('LTR direction applied for English');
            }
        }
        
        // Add manual direction change triggers for Google Translate
        function addDirectionTriggers() {
            // Wait for Google Translate to load
            setTimeout(function() {
                // Find Google Translate dropdowns
                const translateDropdowns = document.querySelectorAll('.goog-te-combo');
                
                translateDropdowns.forEach(function(dropdown) {
                    dropdown.addEventListener('change', function() {
                        console.log('Google Translate dropdown changed to:', this.value);
                        
                        // Check the selected value specifically
                        if (this.value === 'ar') {
                            console.log('Arabic selected, applying RTL');
                            setTimeout(function() {
                                applyRTL();
                            }, 1000);
                        } else if (this.value === 'en') {
                            console.log('English selected, applying LTR');
                            setTimeout(function() {
                                applyLTR();
                            }, 1000);
                        } else {
                            // Fallback to general check
                            setTimeout(function() {
                                checkCurrentLanguage();
                            }, 1000);
                        }
                    });
                });
                
                // Also listen for clicks on Google Translate options
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.goog-te-menu-value')) {
                        setTimeout(function() {
                            checkCurrentLanguage();
                        }, 1500);
                    }
                });
                
            }, 2000);
        }
        
        // Initialize direction triggers
        addDirectionTriggers();
        
        // Set default LTR direction on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, setting default LTR direction');
            applyLTR();
        });
        
        // Function to hide Google Translate top bar
        function hideGoogleTranslateBar() {
            // Hide the top banner iframe (but not the dropdown)
            const iframe = document.querySelector('iframe.skiptranslate');
            if (iframe && !iframe.closest('.goog-te-gadget')) {
                iframe.style.display = 'none';
                iframe.style.visibility = 'hidden';
                iframe.style.height = '0';
                iframe.style.overflow = 'hidden';
            }
            
            // Remove top spacing
            document.body.style.top = '0px';
            
            // Hide Google Translate banners (but not dropdowns)
            const banners = document.querySelectorAll('.goog-te-banner-frame.skiptranslate');
            banners.forEach(function(banner) {
                if (!banner.classList.contains('goog-te-gadget') && !banner.closest('.goog-te-gadget')) {
                    banner.style.display = 'none';
                    banner.style.visibility = 'hidden';
                    banner.style.height = '0';
                    banner.style.overflow = 'hidden';
                }
            });
            
            // Hide the "Show original" bar
            const showOriginalBar = document.querySelector('.goog-te-banner-frame.goog-te-banner-frame-bottom');
            if (showOriginalBar) {
                showOriginalBar.style.display = 'none';
            }
            
            // Ensure the dropdown remains visible and functional
            const dropdowns = document.querySelectorAll('.goog-te-gadget');
            dropdowns.forEach(function(dropdown) {
                dropdown.style.display = 'block';
                dropdown.style.visibility = 'visible';
                dropdown.style.pointerEvents = 'auto';
                dropdown.style.zIndex = '9999';
                
                // Ensure the dropdown combo is clickable
                const combo = dropdown.querySelector('.goog-te-combo');
                if (combo) {
                    combo.style.pointerEvents = 'auto';
                    combo.style.cursor = 'pointer';
                    combo.disabled = false;
                    combo.style.opacity = '1';
                    
                    // Remove any event blocking
                    combo.onclick = null;
                    combo.onmousedown = null;
                    combo.onmouseup = null;
                }
                
                // Ensure the dropdown menu is accessible
                const menu = dropdown.querySelector('.goog-te-menu');
                if (menu) {
                    menu.style.display = 'block';
                    menu.style.visibility = 'visible';
                    menu.style.pointerEvents = 'auto';
                    menu.style.zIndex = '10000';
                }
            });
        }
        
        // Run the hide function immediately and periodically
        hideGoogleTranslateBar();
        setInterval(hideGoogleTranslateBar, 1000);
        
        // Also run after page load
        window.addEventListener('load', function() {
            setTimeout(hideGoogleTranslateBar, 1000);
            setTimeout(hideGoogleTranslateBar, 3000);
        });
        
        // Function to ensure dropdown is clickable
        function ensureDropdownClickable() {
            const dropdowns = document.querySelectorAll('.goog-te-gadget .goog-te-combo');
            dropdowns.forEach(function(dropdown) {
                // Remove any disabled state
                dropdown.disabled = false;
                dropdown.style.pointerEvents = 'auto';
                dropdown.style.cursor = 'pointer';
                dropdown.style.opacity = '1';
                
                // Add click event if needed
                dropdown.onclick = function() {
                    this.focus();
                };
                
                // Ensure it's not blocked by other elements
                dropdown.style.zIndex = '9999';
            });
        }
        
        // Ensure dropdown is clickable periodically
        setInterval(ensureDropdownClickable, 2000);
        
        // Also ensure it's clickable after Google Translate loads
        setTimeout(ensureDropdownClickable, 3000);
        setTimeout(ensureDropdownClickable, 5000);
        
        // Function to fix dropdown functionality with custom styles
        function fixDropdownWithCustomStyles() {
            const dropdowns = document.querySelectorAll('#google_translate_element .goog-te-gadget-simple .goog-te-combo');
            dropdowns.forEach(function(dropdown) {
                // Ensure it's clickable
                dropdown.style.pointerEvents = 'auto';
                dropdown.style.cursor = 'pointer';
                dropdown.style.opacity = '1';
                dropdown.disabled = false;
                
                // Remove any blocking styles
                dropdown.style.display = 'block';
                dropdown.style.visibility = 'visible';
                
                // Add click handler
                dropdown.onclick = function(e) {
                    e.stopPropagation();
                    this.focus();
                };
                
                // Ensure dropdown menu is accessible
                const menu = dropdown.closest('.goog-te-gadget-simple').querySelector('.goog-te-menu');
                if (menu) {
                    menu.style.zIndex = '10000';
                    menu.style.pointerEvents = 'auto';
                    menu.style.display = 'block';
                }
            });
        }
        
        // Run the fix function periodically
        setInterval(fixDropdownWithCustomStyles, 2000);
        setTimeout(fixDropdownWithCustomStyles, 3000);
        setTimeout(fixDropdownWithCustomStyles, 5000);
        
        // Fallback if Google Translate fails to load
        setTimeout(function() {
            if (typeof google === 'undefined' || !google.translate) {
                console.log('Google Translate not loaded, showing fallback');
                // Show fallback language selector
                const fallbackSelector = document.getElementById('fallback_language_selector');
                if (fallbackSelector) {
                    fallbackSelector.style.display = 'block';
                }
                // Hide loading and show content
                const preloader = document.querySelector('.preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }
        }, 5000);
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>
    
    <!-- Google Translate Widget Styling -->
    <style>
        /* Hide Google Translate top bar completely */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }
        
        /* Remove top spacing caused by the hidden iframe */
        body {
            top: 0px !important;
        }
        
        /* Hide the iframe that sometimes appears */
        iframe.VIpgJd-ZVi9od-ORHb-OEVmcd {
            display: none !important;
        }
        
        /* Hide the "Show original" bar */
        .goog-te-banner-frame.goog-te-banner-frame-bottom {
            display: none !important;
        }
        
        /* Hide Google Translate top notification bar (but not dropdown) */
        body > .goog-te-banner-frame:not(.goog-te-gadget) {
            display: none !important;
        }
        
        /* Ensure the dropdown remains visible and functional */
        .goog-te-gadget {
            display: block !important;
            visibility: visible !important;
            pointer-events: auto !important;
            z-index: 9999 !important;
        }
        
        /* Ensure dropdown combo is clickable */
        .goog-te-gadget .goog-te-combo {
            pointer-events: auto !important;
            cursor: pointer !important;
            opacity: 1 !important;
        }
        
        /* Ensure dropdown menu is accessible */
        .goog-te-gadget .goog-te-menu {
            z-index: 10000 !important;
            pointer-events: auto !important;
        }
        
        /* Style the translate dropdown */
        .goog-te-gadget {
            font-family: inherit !important;
        }
        
        .goog-te-gadget .goog-te-combo {
            background: white !important;
            border: 1px solid #e0e0e0 !important;
            color: #333 !important;
            padding: 10px 15px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
            min-width: 120px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        
        .goog-te-gadget .goog-te-combo:focus {
            outline: none !important;
            border-color: #007bff !important;
            box-shadow: 0 2px 8px rgba(0,123,255,0.2) !important;
        }
        
        /* Style the dropdown arrow */
        .goog-te-gadget .goog-te-combo::after {
            content: "▼" !important;
            color: #888 !important;
            font-size: 12px !important;
            margin-left: 8px !important;
        }
        
        /* Hide the default Google Translate arrow */
        .goog-te-gadget .goog-te-combo option {
            background: white !important;
            color: #333 !important;
        }
        
        /* Style the dropdown menu */
        .goog-te-gadget .goog-te-menu {
            background: white !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
            margin-top: 4px !important;
        }
        
        .goog-te-gadget .goog-te-menu-value {
            padding: 10px 15px !important;
            color: #333 !important;
            font-size: 14px !important;
        }
        
        .goog-te-gadget .goog-te-menu-value:hover {
            background: #f8f9fa !important;
        }
        
        /* Mobile styling */
        #google_translate_element_mobile .goog-te-gadget .goog-te-combo {
            background: white !important;
            border: 1px solid #e0e0e0 !important;
            color: #333 !important;
            width: 100% !important;
            padding: 10px 15px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
            height: 40px !important;
        }
        
        /* RTL Support for Google Translate */
        body[dir="rtl"] {
            direction: rtl;
            text-align: right;
        }
        
        body[dir="rtl"] .vl-main-menu ul {
            direction: rtl;
        }
        
        body[dir="rtl"] .vl-main-menu li {
            float: right;
        }
        
        body[dir="rtl"] .vl-hero-btn {
            text-align: left;
        }
        
        body[dir="rtl"] .text-end {
            text-align: left !important;
        }
        
        body[dir="rtl"] .text-start {
            text-align: right !important;
        }
        
        /* RTL support for Bootstrap utilities */
        body[dir="rtl"] .me-1, body[dir="rtl"] .me-2, body[dir="rtl"] .me-3 {
            margin-left: 0.25rem !important;
            margin-right: 0 !important;
        }
        
        body[dir="rtl"] .ms-1, body[dir="rtl"] .ms-2, body[dir="rtl"] .ms-3 {
            margin-right: 0.25rem !important;
            margin-left: 0 !important;
        }
        
        body[dir="rtl"] .pe-1, body[dir="rtl"] .pe-2, body[dir="rtl"] .pe-3 {
            padding-left: 0.25rem !important;
            padding-right: 0 !important;
        }
        
        body[dir="rtl"] .ps-1, body[dir="rtl"] .ps-2, body[dir="rtl"] .ps-3 {
            padding-right: 0.25rem !important;
            padding-left: 0 !important;
        }
        
        /* RTL support for form elements */
        body[dir="rtl"] input, body[dir="rtl"] textarea, body[dir="rtl"] select {
            text-align: right;
        }
        
        /* RTL support for icons */
        body[dir="rtl"] .fa-arrow-right:before {
            content: "\f060"; /* left arrow */
        }
        
        body[dir="rtl"] .fa-angle-right:before {
            content: "\f104"; /* left angle */
        }
        
        /* RTL support for dropdowns */
        body[dir="rtl"] .dropdown-menu {
            right: 0;
            left: auto;
        }
        
        /* RTL support for carousels */
        body[dir="rtl"] .slick-prev {
            right: -25px;
            left: auto;
        }
        
        body[dir="rtl"] .slick-next {
            left: -25px;
            right: auto;
        }
        
        /* Ensure testimonials work in RTL */
        body[dir="rtl"] .testimonial3-slider-boxarea,
        body[dir="rtl"] .testimonial-slider-boxarea {
            direction: ltr;
            text-align: left;
        }
        
        body[dir="rtl"] .testimonai3-slider-area,
        body[dir="rtl"] .testimonai2-slider-area {
            direction: ltr;
        }
    </style>
    
    <!-- Backup preloader hide function -->
    <script>
        // Ensure preloader is hidden after page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                const preloader = document.querySelector('.preloader');
                if (preloader && preloader.style.display !== 'none') {
                    preloader.style.display = 'none';
                    console.log('Backup preloader hide executed');
                }
            }, 2000);
        });
        
        // Additional fallback - hide preloader after 3 seconds regardless
        setTimeout(function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.display = 'none';
                console.log('Emergency preloader hide executed');
            }
        }, 3000);
        
        // Debug function to manually check and apply direction
        window.forceDirectionCheck = function() {
            console.log('Manual direction check triggered');
            checkCurrentLanguage();
        };
        
    </script>

</body>
</html>