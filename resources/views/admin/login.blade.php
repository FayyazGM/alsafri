<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">    
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Title-->
        <title> Login</title>
        
        <!-- Favicon -->
        <link rel="icon" href="{{asset('admin_assets/myimages/IEO_Logo.png')}}" type="image/x-icon">

        <!-- Main Theme Js -->
        <script src="{{asset('admin_assets/authentication-main.js')}}"></script>

        <!-- Bootstrap Css -->
        <link id="style" href="{{asset('admin_assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" >

        <!-- ICONS CSS -->
        <link href="{{asset('admin_assets/icon-fonts/icons.css')}}" rel="stylesheet">

        <!-- APP CSS & APP SCSS -->
        <link rel="preload" as="style" href="{{asset('admin_assets/app-BXaKe1N-.css')}}" /><link rel="stylesheet" href="{{asset('admin_assets/app-BXaKe1N-.css')}}" />
        <!-- Notify CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        {{-- custom styles --}}
        <link href="{{asset('admin_assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('admin_assets/js/jquery.min.js')}}"></script>
    </head>

	<body class="authentication-background">
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card my-4">
                        <div class="card-body p-5">
                            <div class="mb-3 d-flex justify-content-center">
                                <a href="{{ route('admin-login')}}">
                                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="desktop-logo" style="height: 120px;">
                                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="desktop-white" style="height: 120px;">
                                </a>
                            </div>
                            <p class="h5 mb-2 text-center">Sign In</p>
                            <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back !</p>
                            <form method="post" id="loginForm">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="signin-username" class="form-label text-default">Email<sup class="fs-12 text-danger">*</sup></label>
                                        <input type="email" class="form-control" id="username" placeholder="Enter email address" name="email" required>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <label for="signin-password" class="form-label text-default d-block">Password<sup class="fs-12 text-danger">*</sup><a href="{{ route('admin.forgot-password') }}" class="float-end fw-normal text-primary">Forgot password?</a></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control create-password-input" id="signin-password" placeholder="password" name="password" required>
                                            <a href="javascript:void(0);" class="show-password-button text-muted" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></a>
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                    Remember password ?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary"  id="loginFormBtn">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap JS -->
        <script src="{{asset('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        	
        <!-- Show Password JS -->
        <script src="{{asset('admin_assets/show-password.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        {{-- Custom Js --}}
        <script src="{{asset('admin_assets/js/script.js')}}"></script>
        <script src="{{asset('admin_assets/js/validate.min.js')}}"></script>
        <script>
            $('#loginForm').validate({
                submitHandler: function() {
                    'use strict';
                    handleAjaxCall($('#loginForm'), "{{ route('login-request') }}", $('#loginFormBtn'), null, onRequestSuccess);
                }
            });
            
            // Override the onRequestSuccess function for login to handle dynamic redirect
            function onRequestSuccess(response, button, buttonText, redirectUrl, form) {
                if (response.success == true) {
                    alertMessage(response.message, false);
                    setTimeout(() => {
                        // Use the redirect URL from server response if available, otherwise use default
                        var finalRedirectUrl = response.redirect_url || "{{ route('admin-dashboard') }}";
                        window.location.href = finalRedirectUrl;
                    }, 2000);
                } else {
                    alertMessage(response.message, true);
                    button.prop('disabled', false);
                    button.html(buttonText);
                    setTimeout(function () {
                        $('.loading-bar').css('transition', 'none');
                        $('.loading-bar').css('width', 0);
                    }, 500);
                }
            }
        </script>

    </body>
</html>