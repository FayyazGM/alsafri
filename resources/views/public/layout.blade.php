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
    
    <!-- Language Switcher Script -->
    <script>
        // Language switching functionality
        function changeLanguage(langCode, langName) {
            console.log('Changing language to:', langCode, langName);
            
            // Update the current language display immediately
            const currentLangElement = document.getElementById('currentLanguage');
            if (currentLangElement) {
                currentLangElement.textContent = langName;
            }
            
            // Store the selected language in localStorage
            localStorage.setItem('selectedLanguage', langCode);
            localStorage.setItem('selectedLanguageName', langName);
            
            // Apply language changes immediately
            applyLanguageChanges(langCode);
        }
        
        // Apply language changes immediately without Google Translate
        function applyLanguageChanges(langCode) {
            // Update HTML attributes
            if (langCode === 'ar') {
                document.documentElement.setAttribute('lang', 'ar');
                document.documentElement.setAttribute('dir', 'rtl');
                document.body.setAttribute('dir', 'rtl');
                document.body.classList.add('rtl');
            } else {
                document.documentElement.setAttribute('lang', 'en');
                document.documentElement.setAttribute('dir', 'ltr');
                document.body.setAttribute('dir', 'ltr');
                document.body.classList.remove('rtl');
            }
            
            // Translate content immediately
            translateContent(langCode);
        }
        
        // Simple content translation function
        function translateContent(langCode) {
            const translations = {
                'en': {
                    'Home': 'Home',
                    'About': 'About',
                    'Services': 'Services',
                    'Projects': 'Projects',
                    'Gallery': 'Gallery',
                    'Contact': 'Contact',
                    'Get A Quote': 'Get A Quote',
                    'Language': 'Language',
                    'Contact Us': 'Contact Us',
                    'Follow Us': 'Follow Us'
                },
                'ar': {
                    'Home': 'الرئيسية',
                    'About': 'من نحن',
                    'Services': 'الخدمات',
                    'Projects': 'المشاريع',
                    'Gallery': 'المعرض',
                    'Contact': 'اتصل بنا',
                    'Get A Quote': 'احصل على عرض سعر',
                    'Language': 'اللغة',
                    'Contact Us': 'اتصل بنا',
                    'Follow Us': 'تابعنا'
                }
            };
            
            const currentTranslations = translations[langCode] || translations['en'];
            
            // Translate navigation items
            const navItems = document.querySelectorAll('.vl-main-menu a, .vl-offcanvas-menu a');
            navItems.forEach(item => {
                const text = item.textContent.trim();
                if (currentTranslations[text]) {
                    item.textContent = currentTranslations[text];
                }
            });
            
            // Translate buttons
            const buttons = document.querySelectorAll('.vl-btn1, .language-btn');
            buttons.forEach(button => {
                const text = button.textContent.trim();
                if (currentTranslations[text]) {
                    button.textContent = currentTranslations[text];
                }
            });
            
            // Translate headings
            const headings = document.querySelectorAll('.vl-offcanvas-sm-title');
            headings.forEach(heading => {
                const text = heading.textContent.trim();
                if (currentTranslations[text]) {
                    heading.textContent = currentTranslations[text];
                }
            });
        }
        
        // Get selected language from localStorage
        function getSelectedLang() {
            return localStorage.getItem('selectedLanguage') || 'en';
        }
        
        // Initialize language on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing language...');
            
            // Check if there's a saved language preference
            const savedLanguage = localStorage.getItem('selectedLanguage');
            const savedLanguageName = localStorage.getItem('selectedLanguageName');
            
            if (savedLanguage && savedLanguageName) {
                console.log('Found saved language preference:', savedLanguage);
                // Apply the saved language immediately
                applyLanguageChanges(savedLanguage);
                
                // Update the language display
                const currentLangElement = document.getElementById('currentLanguage');
                if (currentLangElement) {
                    currentLangElement.textContent = savedLanguageName;
                }
            } else {
                // Default to English
                applyLanguageChanges('en');
            }
        });
        
        // Apply RTL/LTR styles based on language
        function applyDirectionStyles() {
            const lang = getSelectedLang();
            
            if (lang === 'ar') {
                document.body.setAttribute("dir", "rtl");
                document.body.classList.add("rtl");
                document.body.setAttribute("lang", "ar");
                document.documentElement.setAttribute("lang", "ar");
                document.documentElement.setAttribute("dir", "rtl");
            } else {
                document.body.setAttribute("dir", "ltr");
                document.body.classList.remove("rtl");
                document.body.setAttribute("lang", "en");
                document.documentElement.setAttribute("lang", "en");
                document.documentElement.setAttribute("dir", "ltr");
            }
        }
        
        // Apply direction styles on load
        document.addEventListener('DOMContentLoaded', applyDirectionStyles);
    </script>

</body>
</html>