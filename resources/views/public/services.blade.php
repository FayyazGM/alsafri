@extends('public.layout')
@section('title', 'Services - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>Our Services</h1>
                    <div class="space16"></div>
                    <a href="{{ route('home') }}">Home <i class="fa-solid fa-angle-right"></i> <span>Our Services</span></a>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4">
                <div class="inner-images-area">
                    <img src="{{ asset('assets/img/elements/elements1.png') }}" alt="" class="elements1">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/hero/hero-img9.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== SERVICE AREA STARTS =======-->
<div class="service1-inenr-widget sp1">
  <div class="container">
    <div class="row">
      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s-icons1.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Elevator & Escalator Cladding Services</a>
            <div class="space16"></div>
            <p>We specialize in stainless steel cladding of escalators and elevators, dismantling and installation services, and accessories for elevators across Saudi Arabia.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s-icons2.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Steel Fabrication & Structures</a>
            <div class="space16"></div>
            <p>We provide comprehensive steel fabrication services including mild steel structures, handrails for staircases, sliding gates, and custom fabrication jobs as per client specifications.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s-icons3.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Water Tanks & Custom Fabrication</a>
            <div class="space16"></div>
            <p>We specialize in stainless steel and mild steel water tanks, custom fabrication jobs, and supply of raw materials including angles, tubes, and steel sheets.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s2-icons1.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Commercial & Residential Electrical Services</a>
            <div class="space16"></div>
            <p>We provide personalized energy solutions for homeowners, businesses, & industries ensuring that you have the most efficient.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s2-icons2.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Comprehensive Energy Solutions for Every Need</a>
            <div class="space16"></div>
            <p>VOLTZ provides custom energy solutions that enhance efficiency, lower costs, and promote sustainability.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s2-icons3.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Sustainable Energy Financing & Consulting</a>
            <div class="space16"></div>
            <p>With rising energy costs and increasing demand for sustainability, VOLTZ is here to help you take control of your energy.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="900">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s3-icons1.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Commercial & Residential Electrical Services</a>
            <div class="space16"></div>
            <p>We provide personalized energy solutions for homeowners, businesses, & industries ensuring that you have the most efficient.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s3-icons2.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Comprehensive Energy Solutions for Every Need</a>
            <div class="space16"></div>
            <p>VOLTZ provides custom energy solutions that enhance efficiency, lower costs, and promote sustainability.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
        <div class="service-main-boxarea">
          <img src="{{ asset('assets/img/all-images/service/s-img1.png') }}" alt="" class="s-img1">
          <div class="icons">
            <img src="{{ asset('assets/img/icons/s3-icons3.svg') }}" alt="">
          </div>
          <div class="space16"></div>
          <div class="content-area">
            <a href="{{ route('contact') }}" class="title">Sustainable Energy Financing & Consulting</a>
            <div class="space16"></div>
            <p>With rising energy costs and increasing demand for sustainability, VOLTZ is here to help you take control of your energy.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-xl-12">
            <div class="space18"></div>
            <div class="pagination-area">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link active" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">...</a></li>
                      <li class="page-item"><a class="page-link" href="#">12</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
  </div>
</div>
<!--===== SERVICE AREA ENDS =======-->
@endsection