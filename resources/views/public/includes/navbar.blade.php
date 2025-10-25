<header class="homepage5-body">
    <div id="vl-header-sticky" class="vl-header-area vl-transparent-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-2 col-md-6 col-6">
                    <div class="vl-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('admin_assets/myimages/logo.png') }}" alt="" style="height: 75px;
                          border-radius: 7px;
                          background: #fff;
                          width: auto;" ></a>
                    </div>
                </div>
                <div class="col-xl-7 d-none d-xl-block">
                    <div class="vl-main-menu text-center">
                        <nav class="vl-mobile-menu-active">
                            <ul>
                                <li>
                                    <a href="{{route('home')}}">Home </a>
                                </li>
                                <li>
                                    <a href="{{route('about')}}">About </a>
                                </li>
                                <li>
                                    <a href="{{route('services')}}">Services </a>
                                </li>
                                <li>
                                  <a href="{{route('projects')}}">Projects </a>
                              </li>
                              <li>
                                <a href="{{route('gallery')}}">Gallery </a>
                            </li>
                            <li>
                              <a href="{{route('contact')}}">Contact </a>
                          </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-6">
                  <div class="vl-hero-btn d-none d-xl-block text-end">
                    <div class="sidebar_btn-area">
                      <div class="language-dropdown">
                        <div class="dropdown">
                          <button class="btn btn-link text-white dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-globe me-1"></i>
                            <span id="currentLanguage">English</span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="#" onclick="changeLanguage('en', 'English')">
                              <i class="flag-icon flag-icon-us me-2"></i>English
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeLanguage('ar', 'العربية')">
                              <i class="flag-icon flag-icon-sa me-2"></i>العربية
                            </a></li>
                          </ul>
                        </div>
                      </div>
                      <button class="hamburger_menu"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                      <path d="M3.33301 8H24.6663M3.33301 16H24.6663M3.33301 24H12.6663" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg></button>
                      <div class="btn_area1">
                        <a href="{{route('contact')}}" class="vl-btn1">Get A Quote <i class="fa-solid fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                    <div class="vl-header-action-item d-block d-xl-none">
                        <button type="button" class="vl-offcanvas-toggle">
                          <i class="fa-solid fa-bars-staggered"></i>
                        </button>
                     </div>
                </div>
            </div>
        </div>
    </div>
  </header>