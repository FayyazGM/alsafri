<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
    </body>
</html>