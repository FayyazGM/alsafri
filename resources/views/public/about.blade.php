@extends('public.layout')
@section('title', 'About - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center p-5">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>About Alsafri</h1>
                    <div class="space16"></div>
                    <a href="{{ route('home') }}">Home <i class="fa-solid fa-angle-right"></i> <span>About Alsafri</span></a>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4">
                <div class="inner-images-area">
                    <img src="{{ asset('assets/img/elements/elements1.png') }}" alt="" class="elements1">
                    {{-- <div class="img1">
                        <img src="{{ asset('assets/img/all-images/hero/hero-img9.png') }}" alt="">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== ABOUT AREA STARTS =======-->
<div class="about2-inner-widget sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="all-images">
                    <div class="img1" data-aos="zoom-in" data-aos-duration="900">
                    <img src="{{ asset('assets/pdf-images/img126.jpg') }}" alt="" style="height: 250px">
                </div>
                <div class="img2 text-end" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="{{ asset('assets/pdf-images/img128.jpg') }}" alt="" style="height: 250px">
                    {{-- <div class="play-btn-area">
                        <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube"><i class="fa-solid fa-play"></i></a>
                    </div> --}}
                </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about2-heading heading1">
                  <h5 class="vl-section-subtitle" data-aos="fade-left" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>About Alsafri</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                  <div class="space16"></div>
                  <h2 class="vl-section-title" data-aos="fade-left" data-aos-duration="1000">Leading Steel Fabrication & Elevator Solutions in Saudi Arabia</h2>
                  <div class="space16"></div>
                  <p data-aos="fade-left" data-aos-duration="1000">Abdullah Barakah Ali Al Safari Al Harby Establishment (Alsafri) specializes in all kinds of mild steel & stainless steel fabrication jobs along with extensive experience in escalators' outer cladding and elevators' cabins & doors cladding across the Kingdom of Saudi Arabia.</p>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                        <div class="space24"></div>
                        <div class="choose-boxarea" data-aos="fade-left" data-aos-duration="1100">
                        <div class="icons">
                        <img src="{{ asset('assets/img/icons/ch-icons1.svg') }}" alt="">
                        </div>
                        <div class="content-area">
                        <a href="{{ route('services') }}">Steel Fabrication Excellence</a>
                        <div class="space16"></div>
                        <p>We specialize in mild steel & stainless steel fabrication with over 20 years of experience in the industry.</p>
                        </div>
                    </div>
                  </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="space24"></div>
                        <div class="choose-boxarea" data-aos="fade-left" data-aos-duration="1100">
                        <div class="icons">
                        <img src="{{ asset('assets/img/icons/ch-icons2.svg') }}" alt="">
                        </div>
                        <div class="content-area">
                        <a href="{{ route('services') }}">Elevator & Escalator Solutions</a>
                        <div class="space16"></div>
                        <p>We have completed over 600 escalators' outer cladding and 200+ elevators' cabins & doors cladding projects.</p>
                        </div>
                    </div>
                  </div>
                    </div>
                    <div class="space24"></div>
                    <div class="btn-area1" data-aos="fade-left" data-aos-duration="1200">
                        <a href="{{ route('services') }}" class="vl-btn1">Learn More<i class="fa-solid fa-arrow-right"></i></a>
                        <div class="call-boxarea" data-aos="fade-left" data-aos-duration="1100">
                        <div class="icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17.751 11.198C17.7508 9.85635 17.2177 8.56973 16.269 7.62104C15.3203 6.67235 14.0337 6.13927 12.692 6.139M21.219 10.844C21.219 9.781 21.0096 8.7284 20.6028 7.74633C20.196 6.76425 19.5997 5.87193 18.848 5.12032C18.0963 4.36871 17.2039 3.77253 16.2218 3.36583C15.2397 2.95913 14.187 2.74987 13.124 2.75M12.531 20.217C12.231 20.08 11.932 19.943 11.633 19.78C10.1664 18.9514 8.81903 17.9273 7.62804 16.736C6.08472 15.2826 4.81669 13.5623 3.88504 11.658C3.38664 10.6351 3.04997 9.54111 2.88704 8.415C2.66722 7.27714 2.7933 6.09953 3.24904 5.034C3.53019 4.57598 3.8697 4.15647 4.25904 3.786C4.41702 3.60924 4.6091 3.46621 4.82372 3.36552C5.03835 3.26482 5.27111 3.20852 5.50804 3.2C6.00104 3.274 6.44804 3.532 6.75604 3.923C7.43004 4.672 8.15304 5.346 8.86404 6.057C9.14404 6.297 9.31904 6.637 9.35104 7.005C9.33904 7.315 9.22004 7.61 9.01404 7.841C8.77704 8.141 8.49004 8.415 8.21604 8.701C8.05035 8.86059 7.9236 9.05614 7.84557 9.27255C7.76754 9.48895 7.74033 9.7204 7.76604 9.949C7.93804 10.484 8.23304 10.972 8.62704 11.372C9.09974 12.0169 9.59505 12.645 10.112 13.255C11.0763 14.3673 12.2185 15.3118 13.492 16.05C13.6684 16.1832 13.8769 16.2672 14.0963 16.2936C14.3157 16.3199 14.5382 16.2876 14.741 16.2C15.164 15.963 15.541 15.65 15.851 15.277C16.1196 14.9503 16.5041 14.74 16.924 14.69C17.298 14.71 17.65 14.87 17.91 15.14C18.246 15.426 18.533 15.763 18.845 16.075C19.157 16.387 19.407 16.612 19.669 16.898C19.983 17.1753 20.278 17.4707 20.554 17.784C20.768 18.061 20.871 18.409 20.841 18.757C20.7296 19.1737 20.4895 19.5446 20.155 19.817C19.684 20.3068 19.1117 20.6878 18.4782 20.9336C17.8447 21.1794 17.1651 21.284 16.487 21.24C15.114 21.1638 13.7688 20.8161 12.531 20.217Z" stroke="#0F0D0D" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                        </svg>
                        </div>
                        <div class="content-area">
                        <p>GIVE US A CALL</p>
                        <div class="space6"></div>
                        <a href="tel:+966-2-2898225">+966-2-2898225</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== ABOUT AREA ENDS =======-->

<!--===== OTHERS AREA STARTS =======-->
<div class="apporch-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-5">
                <div class="heading1">
                    <h5 class="vl-section-subtitle" data-aos="fade-left" data-aos-duration="800"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>Our Approach</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                    <div class="space16"></div>
                    <h2 class="vl-section-title" data-aos="fade-left" data-aos-duration="900">Excellence in Steel Fabrication & Elevator Solutions</h2>
                    <div class="space24"></div>
                    <h3>Our Vision</h3>
                    <div class="space16"></div>
                    <p data-aos="fade-left" data-aos-duration="1000">At Alsafri, we envision becoming the leading steel fabrication and elevator solutions provider in Saudi Arabia, known for our commitment to quality, innovation, and customer satisfaction in every project we undertake.</p>
                    <div class="space30"></div>
                    <h3>Our Mission</h3>
                    <div class="space16"></div>
                    <p>Our mission is to deliver superior steel fabrication and elevator cladding solutions that exceed client expectations, while maintaining the highest standards of quality, safety, and on-time delivery across all our projects in Saudi Arabia.</p>
                    <div class="space38"></div>
                    <div class="btn-area1">
                        <a href="{{ route('projects') }}" class="vl-btn1">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="images-app-area">
                    <div class="img1 text-end">
                        <img src="{{ asset('assets/pdf-images/img130.jpg') }}" alt="" style="height: 250px">
                    </div>
                    <div class="img2">
                        <img src="{{ asset('assets/pdf-images/img132.jpg') }}" alt="" style="height: 250px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== OTHERS AREA ENDS =======-->

<!--===== CHOOSE AREA STARTS =======-->
<div class="choose1-inner-widget sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="choose-heading heading1">
                    <h5 class="vl-section-subtitle" data-aos="fade-left" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>WHY CHOOSE ALSAFRI</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                  <div class="space16"></div>
                  <h2 class="vl-section-title" data-aos="fade-left" data-aos-duration="1000">Two Decades of Excellence in Steel Fabrication</h2>
                  <div class="space16"></div>
                  <p data-aos="fade-left" data-aos-duration="1000">At Alsafri, we have been delivering exceptional steel fabrication and elevator solutions since 2003. With over 20 years of experience, we have completed 600+ escalator cladding projects and 200+ elevator installations across Saudi Arabia, serving major clients like Kone, Fujitec, Schindler, and Otis.</p>
                  <div class="space24"></div>
                  <div class="choose-boxarea" data-aos="fade-left" data-aos-duration="1100">
                        <div class="icons">
                        <img src="{{ asset('assets/img/icons/ch-icons1.svg') }}" alt="">
                        </div>
                        <div class="content-area">
                        <a href="{{ route('services') }}">Comprehensive Steel Fabrication Services</a>
                        <div class="space16"></div>
                        <p>We provide comprehensive steel fabrication services including mild steel & stainless steel structures, handrails, water tanks, and custom fabrication jobs tailored to client specifications.</p>
                        </div>
                    </div>
                    <div class="space24"></div>
                    <div class="choose-boxarea" data-aos="fade-left" data-aos-duration="1200">
                        <div class="icons">
                        <img src="{{ asset('assets/img/icons/ch-icons2.svg') }}" alt="">
                        </div>
                        <div class="content-area">
                        <a href="{{ route('services') }}">Elevator & Escalator Cladding Expertise</a>
                        <div class="space16"></div>
                        <p>Our specialized team has completed over 600 escalators' outer cladding and 200+ elevators' cabins & doors cladding projects across major shopping malls, hospitals, and commercial buildings.</p>
                        </div>
                    </div>
                    <div class="space38"></div>
                    <div class="btn-area1">
                        <a href="{{ route('projects') }}" class="vl-btn1">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="choose-images-area">
                    <img src="{{ asset('assets/img/elements/elements10.png') }}" alt="" class="elements10 aniamtion-key-2">
                    <div class="img1" data-aos="fade-right" data-aos-duration="1000">
                        <img src="{{ asset('assets/pdf-images/img136.jpg') }}" alt="" style="height: 350px">
                    </div>
                    <div class="img2 text-end" data-aos="fade-left" data-aos-duration="1000">
                        <img src="{{ asset('assets/pdf-images/img137.jpg') }}" alt="" style="height: 350px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CHOOSE AREA ENDS =======-->

<!--===== TESTIMONIAL AREA START =======-->
<div class="testimonial5 sp1">
  <div class="container">
    <div class="row">
          <div class="col-xl-6 m-auto">
         <div class="heading1 text-center space-margin60">
                  <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>CLIENT TESTIMONIALS</span></h5>
            <div class="space16"></div>
                 <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Trusted by Leading Companies Across Saudi Arabia</h2>
          </div>
      </div>
    </div>
    
    <div class="row">
          <div class="col-xl-12">
              <div class="testimonai3-slider-area" data-aos="zoom-in-up" data-aos-duration="1000">
                  <div class="testimonial3-slider-boxarea">
                      <div class="images">
                          <div class="img1">
                              <img src="{{ asset('assets/img/logos/kone.png') }}" alt="Kone logo">
                </div>
                </div>
                <ul>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
                <div class="space16"></div>
                      <p>"Alsafri's expertise in elevator cladding and steel fabrication has been exceptional. Their quality work and timely delivery have made them our preferred partner for major projects."</p>
                      <div class="space24"></div>
                      <div class="content-man-area">
                <div class="text">
                              <a href="#contact">Kone Areeco Ltd</a>
                    <div class="space12"></div>
                              <p>Elevator & Escalator Company</p>
                  </div>
              </div>
            </div>

                  <div class="testimonial3-slider-boxarea">
                      <div class="images">
                          <div class="img1">
                              <img src="{{ asset('assets/img/logos/fujitec.png') }}" alt="Fujitec logo">
                </div>
                </div>
                <ul>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
                <div class="space16"></div>
                      <p>"Working with Alsafri has been a game-changer for our projects. Their attention to detail and commitment to quality in steel fabrication is unmatched in the industry."</p>
                       <div class="space24"></div>
                      <div class="content-man-area">
                <div class="text">
                              <a href="#contact">Fujitec Saudi Arabia</a>
                    <div class="space12"></div>
                              <p>Elevator & Escalator Company</p>
                  </div>
              </div>
            </div>

                  <div class="testimonial3-slider-boxarea">
                      <div class="images">
                              <div class="img1">
                                  <img src="{{ asset('assets/img/logos/schindler.png') }}" alt="Schindler logo">
                              </div>
                </div>
                <ul>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
                <div class="space16"></div>
                      <p>"Alsafri's professional approach and technical expertise have consistently delivered outstanding results for our complex steel fabrication requirements."</p>
                      <div class="space24"></div>
                      <div class="content-man-area">
                <div class="text">
                              <a href="#contact">Schindler Elevator Co.</a>
                    <div class="space12"></div>
                              <p>Elevator & Escalator Company</p>
                  </div>
              </div>
            </div>

                  <div class="testimonial3-slider-boxarea">
                      <div class="images">
                          <div class="img1">
                              <img src="{{ asset('assets/img/logos/otis.png') }}" alt="Otis logo">
                          </div>
                </div>
                <ul>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
                <div class="space16"></div>
                      <p>"Alsafri stands for quality, commitment & on-time delivery. Their inherent belief in safeguarding customer interests professionally makes them our trusted partner."</p>
                      <div class="space24"></div>
                      <div class="content-man-area">
                <div class="text">
                              <a href="#contact">Otis Elevator Co.</a>
                    <div class="space12"></div>
                              <p>Elevator & Escalator Company</p>
                          </div>
                  </div>
              </div>

            </div>
          </div>
        </div>
          </div>
          </div>
<!--===== TESTIMONIAL AREA END =======-->

<!--===== TEAM AREA STARTS =======-->
<div class="team5 sp2">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""><span>Our team</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                   <div class="space16"></div>
                   <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Meet Our Executive Team</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="900">
                <div class="team5-boxarea">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/team/t-img10.png') }}" alt="">
                    </div>
                    <div class="content-area">
                        <a href="{{ route('about') }}" class="title">Mr. Abdullah Barakah Ali Al-Safari Al-Harby</a>
                        <div class="space12"></div>
                        <p>Chairman</p>
                    </div>
                    <ul>
                         <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                <div class="team5-boxarea">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/team/t-img11.png') }}" alt="">
                    </div>
                    <div class="content-area">
                        <a href="{{ route('about') }}" class="title">Mr. Mohammad Awad Al-Harby</a>
                        <div class="space12"></div>
                        <p>Chief Executive Officer (CEO)</p>
                    </div>
                    <ul>
                         <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="`1200">
                <div class="team5-boxarea">
                    <div class="img1">
                        <img src="{{ asset('assets/img/all-images/team/t-img12.png') }}" alt="">
                    </div>
                    <div class="content-area">
                        <a href="{{ route('about') }}" class="title">Mr. Tasawar Mahmood</a>
                        <div class="space12"></div>
                        <p>General Manager</p>
                    </div>
                    <ul>
                         <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== TEAM AREA END =======-->


@endsection