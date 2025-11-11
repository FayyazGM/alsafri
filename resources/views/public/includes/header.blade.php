<!--=====FAB ICON=======-->
<link rel="shortcut icon" href="{{ asset('assets/img/logo/fav-logo1.png') }}" type="image/x-icon">
    
<!--===== CSS LINK =======-->
<link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/aos.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/slick-slider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/nice-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-slider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

<!-- Language Dropdown Styles -->
<style>
.language-dropdown .dropdown-toggle {
    background: none !important;
    border: none !important;
    color: white !important;
    padding: 8px 12px !important;
    font-size: 14px;
    text-decoration: none !important;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.language-dropdown .dropdown-toggle:hover {
    color: #007bff !important;
    background: rgba(255, 255, 255, 0.1) !important;
    border-radius: 5px;
}

.language-dropdown .dropdown-toggle:focus {
    box-shadow: none !important;
    outline: none !important;
}

.language-dropdown .dropdown-menu {
    min-width: 150px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 8px 0;
    margin-top: 5px;
}

.language-dropdown .dropdown-item {
    padding: 8px 16px;
    display: flex;
    align-items: center;
    font-size: 14px;
    transition: all 0.3s ease;
}

.language-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}

.language-dropdown .dropdown-item i {
    width: 20px;
    height: 15px;
    background-size: cover;
    background-position: center;
    border-radius: 2px;
}

.flag-icon-us {
    background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjE1IiBmaWxsPSIjRkZGRkZGIi8+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjQ0MxNDI0Ii8+CjxyZWN0IHk9IjEuMTUiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjRkZGRkZGIi8+CjxyZWN0IHk9IjIuMyIgd2lkdGg9IjIwIiBoZWlnaHQ9IjEuMTUiIGZpbGw9IiNDQzE0MjQiLz4KPHJlY3QgeT0iMy40NSIgd2lkdGg9IjIwIiBoZWlnaHQ9IjEuMTUiIGZpbGw9IiNGRkZGRkYiLz4KPHJlY3QgeT0iNC42IiB3aWR0aD0iMjAiIGhlaWdodD0iMS4xNSIgZmlsbD0iI0NDMTQyNCIvPgo8cmVjdCB5PSI1Ljc1IiB3aWR0aD0iMjAiIGhlaWdodD0iMS4xNSIgZmlsbD0iI0ZGRkZGRiIvPgo8cmVjdCB5PSI2LjkiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjQ0MxNDI0Ii8+CjxyZWN0IHk9IjguMDUiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjRkZGRkZGIi8+CjxyZWN0IHk9IjkuMiIgd2lkdGg9IjIwIiBoZWlnaHQ9IjEuMTUiIGZpbGw9IiNDQzE0MjQiLz4KPHJlY3QgeT0iMTAuMzUiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjRkZGRkZGIi8+CjxyZWN0IHk9IjExLjUiIHdpZHRoPSIyMCIgaGVpZ2h0PSIxLjE1IiBmaWxsPSIjQ0MxNDI0Ii8+CjxyZWN0IHk9IjEyLjY1IiB3aWR0aD0iMjAiIGhlaWdodD0iMS4xNSIgZmlsbD0iI0ZGRkZGRiIvPgo8cmVjdCB5PSIxMy44IiB3aWR0aD0iMjAiIGhlaWdodD0iMS4xNSIgZmlsbD0iI0NDMTQyNCIvPgo8cmVjdCB5PSIxNC45NSIgd2lkdGg9IjIwIiBoZWlnaHQ9IjEuMDUiIGZpbGw9IiNGRkZGRkYiLz4KPHJlY3Qgd2lkdGg9IjcuNjkiIGhlaWdodD0iOC4wNSIgZmlsbD0iIzAwMzM5OCIvPgo8L3N2Zz4K');
}

.flag-icon-sa {
    background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTUiIHZpZXdCb3g9IjAgMCAyMCAxNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjE1IiBmaWxsPSIjMDA2MzAwIi8+CjxwYXRoIGQ9Ik0wIDcuNUgyMFY4LjVIMFY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik0zIDcuNUgxN1Y4LjVIM1Y3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik0yIDcuNUgxOFY4LjVIMlY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik0xIDcuNUgxOVY4LjVIMVY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik00IDcuNUgxNlY4LjVINFY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik01IDcuNUgxNVY4LjVINVY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik02IDcuNUgxNFY4LjVINlY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik03IDcuNUgxM1Y4LjVIN1Y3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik04IDcuNUgxMlY4LjVIOFY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik05IDcuNUgxMVY4LjVIOVY3LjVaIiBmaWxsPSIjRkZGRkZGIi8+CjxwYXRoIGQ9Ik0xMCA3LjVIMTBWOC41SDEwVjcuNVoiIGZpbGw9IiNGRkZGRkYiLz4KPC9zdmc+Cg==');
}

    /* Language switching styles - no Google Translate needed */

/* Google Translate Widget Styling */
.goog-te-banner-frame {
    display: none !important;
}

.goog-te-gadget {
    font-family: inherit !important;
}

.goog-te-gadget .goog-te-combo {
    background: transparent !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    color: white !important;
    padding: 8px 12px !important;
    border-radius: 5px !important;
    font-size: 14px !important;
}

.goog-te-gadget .goog-te-combo:focus {
    outline: none !important;
    border-color: #007bff !important;
}

/* Mobile Language Options */
.vl-offcanvas-language .language-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.vl-offcanvas-language .language-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    font-size: 14px;
    transition: all 0.3s ease;
    width: 100%;
    text-align: left;
}

.vl-offcanvas-language .language-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.vl-offcanvas-language .language-btn i {
    width: 20px;
    height: 15px;
    background-size: cover;
    background-position: center;
    border-radius: 2px;
    margin-right: 10px;
}
#google_translate_element{
    position: static;
}

#google_translate_element .goog-te-gadget-simple{
    padding: 6px 8px;
    border-radius: 8px;
}

#google_translate_element .goog-te-gadget-simple img{
    display: none;
}

#goog-gt-tt{
    display: none !important;
}


.goog-te-banner-frame.skiptranslate {
    display: none !important;
}

body {
    top: 0 !important;
    position: static !important;
}

.skiptranslate iframe {
    visibility: hidden !important;
}

/* Loader Logo Centering */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#loading-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
}

#loading-icon img {
    display: block;
    margin: 0 auto;
}
</style>