<aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="{{route('admin-dashboard')}}" class="header-logo">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="desktop-logo">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="toggle-dark">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="desktop-dark">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="toggle-logo">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo" class="toggle-white">
                    <img src="{{asset('admin_assets/myimages/logo.png')}}" alt="logo"
                        class="desktop-white">
                </a>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                    </div>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <li class="slide__category"><span class="category-name">Main</span></li>
                        <!-- End::slide__category -->
                        <li class="slide">
                            <a href="{{ route('admin-dashboard') }}" class="side-menu__item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 side-menu__icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{route('admin.profile.index')}}" class="side-menu__item">
                                <i class="uil uil-user w-6 h-6 side-menu__icon"></i>
                                <span class="side-menu__label">My Profile </span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{route('admin-logout')}}" class="side-menu__item">
                                <i class="uil uil-power w-6 h-6 side-menu__icon"></i>
                                <span class="side-menu__label">Log Out </span>
                            </a>
                        </li>
                    </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg"
                            fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg></div>
                </nav>
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>