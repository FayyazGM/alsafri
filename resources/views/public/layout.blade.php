<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title')</title>
    @yield('custom-css')
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
        
        // Function to re-initialize testimonial slider
        function reinitializeTestimonialSlider() {
            // Wait a bit for Google Translate to finish modifying the DOM
            setTimeout(function() {
                // Check if jQuery and Slick are available
                if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
                    console.log('jQuery or Slick not available yet, retrying...');
                    setTimeout(reinitializeTestimonialSlider, 500);
                    return;
                }
                
                const sliderArea = jQuery('.testimonai3-slider-area');
                if (sliderArea.length > 0) {
                    // Check if slider is already initialized
                    if (sliderArea.hasClass('slick-initialized')) {
                        // Destroy existing slider
                        sliderArea.slick('unslick');
                        console.log('Testimonial slider destroyed');
                    }
                    
                    // Re-initialize the slider
                    sliderArea.slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false,
                        centerMode: false,
                        focusOnSelect: true,
                        loop: true,
                        autoplay: true,
                        autoplaySpeed: 2000,
                        infinite: true,
                        rtl: document.documentElement.getAttribute('dir') === 'rtl',
                        responsive: [
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    infinite: true,
                                }
                            },
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                    console.log('Testimonial slider re-initialized');
                    
                    // Ensure slider is visible
                    sliderArea.css('display', 'block');
                    sliderArea.css('visibility', 'visible');
                    sliderArea.css('opacity', '1');
                }
            }, 1500);
        }
        
        // Apply RTL direction
        function applyRTL() {
            if (!document.documentElement.getAttribute('dir') || document.documentElement.getAttribute('dir') !== 'rtl') {
                document.documentElement.setAttribute('dir', 'rtl');
                document.documentElement.setAttribute('lang', 'ar');
                document.body.classList.add('rtl');
                document.body.classList.remove('ltr');
                console.log('RTL direction applied for Arabic');
                // Re-initialize slider after RTL is applied
                reinitializeTestimonialSlider();
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
                // Re-initialize slider after LTR is applied
                reinitializeTestimonialSlider();
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
                // Re-initialize slider after RTL is applied
                reinitializeTestimonialSlider();
            } else if (element.classList.contains('translated-ltr')) {
                // English selected - apply LTR styles
                document.documentElement.setAttribute('dir', 'ltr');
                document.documentElement.setAttribute('lang', 'en');
                document.body.classList.remove('rtl');
                console.log('LTR direction applied for English');
                // Re-initialize slider after LTR is applied
                reinitializeTestimonialSlider();
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
        /* Hide Google Translate branding */
        .goog-te-banner-frame {
            display: none !important;
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
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure slider container is visible in RTL */
        body[dir="rtl"] .testimonial5 .testimonai3-slider-area {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            height: auto !important;
            overflow: visible !important;
        }
        
        body[dir="rtl"] .testimonial5 .testimonial3-slider-boxarea {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
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