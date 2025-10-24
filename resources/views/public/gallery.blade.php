@extends('public.layout')
@section('title', 'Gallery - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>Project Gallery</h1>
                    <div class="space16"></div>
                    <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>Gallery</span></a>
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

<!--===== GALLERY AREA STARTS =======-->
<div class="project-inner-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>OUR WORK</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                    <div class="space16"></div>
                    <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Showcasing Our Steel Fabrication Excellence</h2>
                    <div class="space16"></div>
                    <p data-aos="zoom-in-up" data-aos-duration="1100">Explore our portfolio of completed projects including elevator cladding, escalator installations, steel structures, and custom fabrication work across Saudi Arabia.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img1.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Elevator Cladding</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Stainless Steel Elevator Cabin & Door Cladding</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img2.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Escalator Cladding</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Outer Cladding for Escalators</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img3.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Steel Structures</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Mild Steel Structures & Handrails</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img4.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Water Tanks</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Stainless Steel Water Tanks</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img5.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Custom Fabrication</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Custom Steel Fabrication Jobs</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/projects/p-img6.png') }}" alt="">
                    </div>
                    <div class="contain-main-area">
                        <div class="content-p-area">
                            <span>Industrial Projects</span>
                            <div class="space12"></div>
                            <a href="#" class="title">Steel Brackets & Accessories</a>
                        </div>
                        <div class="arrow">
                            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== GALLERY AREA ENDS =======-->
@endsection