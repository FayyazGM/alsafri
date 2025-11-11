@extends('public.layout')

@section('title', 'Alsafri - السفري')

@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="hero-main-section-area5">
  <img src="{{ asset('assets/pdf-images/img102.jpg') }}" alt="" class="hero-bg1">
    <div class="container">
      <div class="row align-items-center">
      <div class="col-xl-8 m-auto">
        <div class="hero1-heading text-center">
          <h1 data-aos="fade-up" data-aos-duration="900">Leading Steel Fabrication & Elevator Solutions in Saudi Arabia</h1>
            <div class="space16"></div>
          <p data-aos="fade-up" data-aos-duration="1000">Abdullah Barakah Ali Al Safari Al Harby Establishment specializes in mild steel & stainless steel fabrication, elevator cladding, and escalator installations across the Kingdom of Saudi Arabia.</p>
            <div class="space38"></div>
          <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
            <a href="#services" class="vl-btn1">Explore Our Services <i class="fa-solid fa-arrow-right"></i></a>
            <a href="#contact" class="h-btn1">Contact Us Now <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        <a href="#about" class="scroll-down">
          <span class="icons">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="44" viewBox="0 0 28 44" fill="none">
              <path d="M14 44C6.26629 44 0 37.1879 0 28.8335V15.1237C0 6.76923 6.26629 0 14 0C21.7337 0 28 6.76923 28 15.1237V28.8335C28 37.1879 21.7337 44 14 44ZM14 3.64167C8.13031 3.64167 3.37111 8.78286 3.37111 15.1237V28.8335C3.37111 35.1743 8.13031 40.3155 14 40.3155C19.8697 40.3155 24.6289 35.1743 24.6289 28.8335V15.1237C24.6289 8.78286 19.8697 3.64167 14 3.64167Z" fill="white"/>
              <path d="M14 18.3333C12.7519 18.3333 11.6667 17.3806 11.6667 16.1772V10.7117C11.6667 9.5584 12.6977 8.55556 14 8.55556C15.3023 8.55556 16.3333 9.50826 16.3333 10.7117V16.1772C16.3333 17.3806 15.3023 18.3333 14 18.3333Z" fill="white"/>
              </svg>
          </span>
            <div class="space16"></div>
          <span class="scroll">Scroll down</span>
        </a>
            </div>
          </div>
        </div>
            </div>
<!--===== HERO AREA ENDS =======-->

<!--===== ABOUT AREA STARTS =======-->
<div class="about5 sp1" id="about">
    <div class="container">
      <div class="row align-items-center">
    <div class="col-xl-6" data-aos="zoom-in-up" data-aos-duration="100">
      <div class="about-images">
            <div class="img1">
          <img src="{{ asset('assets/pdf-images/img103.jpg') }}" alt="">
            </div>
        <div class="experiance-area">
          <p>25 Years of Experience</p>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
      <div class="about-heading heading3">
        <h5 class="vl-section-subtitle" data-aos="fade-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>About Alsafri Establishment</span></h5>
          <div class="space16"></div>
        <h2 class="vl-section-title" data-aos="fade-up" data-aos-duration="1000">Excellence in Steel Fabrication & Elevator Solutions</h2>
          <div class="space16"></div>
        <p data-aos="fade-up" data-aos-duration="1100">Established in 2003, Alsafri has been providing specialized steel fabrication services with over 20 years of experience. We have completed more than 600 escalator cladding projects and over 200 elevator cabin & door cladding projects across Saudi Arabia.</p>
        <div class="row" data-aos="fade-up" data-aos-duration="1200">
          <div class="col-xl-6 col-md-6">
            <div class="circle-wrapper">
              <div class="circle-box">
                <div class="circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                <path d="M62 31.0009C62 48.1217 48.1208 62.0009 31 62.0009C13.8792 62.0009 0 48.1217 0 31.0009C0 13.88 13.8792 0.000854492 31 0.000854492C48.1208 0.000854492 62 13.88 62 31.0009ZM4.65 31.0009C4.65 45.5536 16.4473 57.3509 31 57.3509C45.5527 57.3509 57.35 45.5536 57.35 31.0009C57.35 16.4482 45.5527 4.65085 31 4.65085C16.4473 4.65085 4.65 16.4482 4.65 31.0009Z" fill="#F4F4F9"/>
                <path d="M58.2715 39.8619C59.4928 40.2587 60.1692 41.5747 59.6821 42.7628C57.1918 48.8357 52.828 53.9823 47.1975 57.4327C40.904 61.2894 33.4409 62.7739 26.1505 61.6192C18.8602 60.4645 12.2211 56.7465 7.42742 51.1337C2.63371 45.521 1.55448e-06 38.3821 0 31.0009C-1.55448e-06 23.6197 2.63371 16.4807 7.42741 10.868C12.2211 5.25526 18.8602 1.53719 26.1505 0.382517C33.4408 -0.772158 40.9039 0.712341 47.1974 4.569C52.828 8.01941 57.1918 13.166 59.682 19.2389C60.1692 20.427 59.4928 21.743 58.2715 22.1398C57.0503 22.5366 55.7482 21.863 55.2453 20.6815C53.108 15.6595 49.4541 11.4055 44.7678 8.53378C39.4184 5.25562 33.0747 3.99379 26.8779 4.97527C20.6812 5.95674 15.0379 9.1171 10.9633 13.8879C6.88865 18.6587 4.65 24.7268 4.65 31.0009C4.65 37.2749 6.88866 43.343 10.9633 48.1138C15.038 52.8846 20.6812 56.045 26.878 57.0264C33.0747 58.0079 39.4184 56.7461 44.7678 53.4679C49.4541 50.5962 53.108 46.3422 55.2453 41.3202C55.7482 40.1387 57.0503 39.4651 58.2715 39.8619Z" fill="#E8040F"/>
              </svg>
                  <h3><span class="counter">90</span>%</h3>
            </div>
                <p>Quality & Precision</p>
            </div>
          </div>
            </div>

          <div class="col-xl-6 col-md-6">
            <div class="circle-wrapper">
              <div class="circle-box">
                <div class="circle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                  <path d="M62 31.0009C62 48.1217 48.1208 62.0009 31 62.0009C13.8792 62.0009 0 48.1217 0 31.0009C0 13.88 13.8792 0.000854492 31 0.000854492C48.1208 0.000854492 62 13.88 62 31.0009ZM4.65 31.0009C4.65 45.5536 16.4473 57.3509 31 57.3509C45.5527 57.3509 57.35 45.5536 57.35 31.0009C57.35 16.4482 45.5527 4.65085 31 4.65085C16.4473 4.65085 4.65 16.4482 4.65 31.0009Z" fill="#F4F4F9"/>
                  <path d="M58.2715 39.8619C59.4928 40.2587 60.1692 41.5747 59.6821 42.7627C57.3484 48.4537 53.366 53.3397 48.2227 56.7764C42.433 60.645 35.5095 62.4516 28.5678 61.9053C21.626 61.359 15.0704 58.4915 9.95718 53.7649C4.84395 49.0382 1.47094 42.7278 0.381662 35.8503C-0.707621 28.9729 0.550263 21.9289 3.95262 15.8536C7.35498 9.77824 12.7037 5.02529 19.1368 2.36059C25.57 -0.304107 32.7129 -0.725348 39.4146 1.16474C45.3682 2.84383 50.6656 6.26011 54.6436 10.9514C55.4741 11.9308 55.2374 13.3914 54.1986 14.1461C53.1597 14.9009 51.7131 14.6626 50.8698 13.6943C47.5152 9.84277 43.1004 7.03563 38.1525 5.64016C32.456 4.03358 26.3845 4.39164 20.9163 6.65663C15.4481 8.92162 10.9017 12.9616 8.00973 18.1257C5.11772 23.2897 4.04852 29.2771 4.97441 35.1229C5.9003 40.9687 8.76736 46.3326 13.1136 50.3503C17.4598 54.3679 23.0321 56.8053 28.9326 57.2696C34.8331 57.734 40.718 56.1983 45.6393 52.9101C49.9139 50.0539 53.2451 46.0199 55.2453 41.3202C55.7482 40.1387 57.0503 39.4651 58.2715 39.8619Z" fill="#E8040F"/>
                </svg>
                  <h3><span class="counter">85</span>%</h3>
            </div>
                <p>On-Time Delivery</p>
          </div>
          </div>
         </div>
      </div>
          <div class="space38"></div>
        <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
            <a href="{{ route('about') }}" class="vl-btn1">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== ABOUT AREA ENDS =======-->

<!--===== SERVICE AREA STARTS =======-->
<div class="service5 sp2">
  <div class="container">
    <div class="row">
    <div class="col-xl-7 m-auto">
        <div class="heading1 text-center space-margin60">
        <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>Our Services</span></h5>
          <div class="space16"></div>
        <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Comprehensive Steel Fabrication & Elevator Solutions</h2>
        </div>
      </div>
    </div>

    <div class="row">
    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1000">
      <div class="service5-boxarea">
        <div class="img1">
          <img src="{{ asset('assets/pdf-images/img104.jpg') }}" alt="" style="height: 400px; width: 100%; object-fit: cover;">
          </div>
        <div class="s-content-area">
          <div class="icons-area">
            <img src="{{ asset('assets/img/icons/s5-icons3.svg') }}" alt="">
            <h4>01</h4>
          </div>
          <div class="space24"></div>
          <a href="#services" class="title">Elevator & Escalator Cladding</a>
          <div class="space16"></div>
          <p>Specialized stainless steel cladding for escalators and elevators, including dismantling, installation, and accessories for elevator systems.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1100">
      <div class="service5-boxarea">
        <div class="img1">
          <img src="{{ asset('assets/pdf-images/img112.jpg') }}" alt="" style="height: 400px; width: 100%; object-fit: cover;">
          </div>
        <div class="s-content-area">
          <div class="icons-area">
            <img src="{{ asset('assets/img/icons/s5-icons2.svg') }}" alt="">
            <h4>01</h4>
          </div>
          <div class="space24"></div>
          <a href="#services" class="title">Steel Structures & Handrails</a>
          <div class="space16"></div>
          <p>Mild steel structures, hangers, and stainless steel handrails for staircases, along with sliding gates and cage ladders for various applications.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="1200">
      <div class="service5-boxarea">
        <div class="img1">
          <img src="{{ asset('assets/pdf-images/img113.jpg') }}" alt="" style="height: 400px; width: 100%; object-fit: cover;">
          </div>
        <div class="s-content-area">
          <div class="icons-area">
            <img src="{{ asset('assets/img/icons/s5-icons1.svg') }}" alt="">
            <h4>01</h4>
          </div>
          <div class="space24"></div>
          <a href="#services" class="title">Water Tanks & Fabrication</a>
          <div class="space16"></div>
          <p>Custom stainless steel and mild steel water tanks, along with all types of fabrication jobs according to client specifications and sketches.</p>
            <div class="space24"></div>
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== SERVICE AREA ENDS =======-->

<!--===== CHOOSE AREA STARTS =======-->
<div class="choose5 sp1">
  <div class="container">
      <div class="row align-items-center">
          <div class="col-xl-6">
              <div class="heading1">
                  <h5 class="vl-section-subtitle" data-aos="fade-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>Why Choose Alsafri</span></h5>
          <div class="space16"></div>
                 <h2 class="vl-section-title" data-aos="fade-up" data-aos-duration="1000">Two Decades of Excellence in Steel Fabrication</h2>
                 <div class="space16"></div>
                 <p data-aos="fade-up" data-aos-duration="1100">With over 20 years of experience and a track record of completing major projects for leading companies like Kone, Fujitec, Schindler, and Otis, we deliver quality, commitment, and on-time delivery.</p>
                 <div class="row" data-aos="fade-up" data-aos-duration="1200">
                  <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                      <div class="space32"></div>
                      <div class="counter-box">
                          <h2><span class="counter">100</span>%</h2>
              <div class="space12"></div>
                          <p>Quality Guarantee</p>
            </div>
          </div>

                  <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                      <div class="space32"></div>
                      <div class="counter-box">
                          <h2><span class="counter">700</span>+</h2>
              <div class="space12"></div>
                          <p>Major Clients</p>
            </div>
          </div>

                  <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                      <div class="space32"></div>
                      <div class="counter-box">
                          <h2><span class="counter">500</span>+</h2>
              <div class="space12"></div>
                          <p>Projects Completed</p>
            </div>
            </div>
            </div>
                 <div class="space32"></div>
                 <div class="btn-area1" data-aos="fade-up" data-aos-duration="1200">
                  <a href="{{ route('projects') }}" class="vl-btn1">Learn More <i class="fa-solid fa-arrow-right"></i></a>
          </div>
            </div>
            </div>
          <div class="col-xl-6" data-aos="zoom-in-up" data-aos-duration="1000">
              <div class="images">
                  <img src="{{ asset('assets/pdf-images/img114.jpg') }}" alt="">
            </div>
            </div>
          </div>
            </div>
            </div>
<!--===== CHOOSE AREA ENDS =======-->

<!--===== SERVICE AREA STARTS =======-->
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
                              <img src="{{ asset('assets/pdf-images/img115.jpg') }}" alt="">
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
                              <img src="{{ asset('assets/pdf-images/img116.jpg') }}" alt="">
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
                                  <img src="{{ asset('assets/pdf-images/img115.jpg') }}" alt="">
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
                              <img src="{{ asset('assets/pdf-images/img115.jpg') }}" alt="">
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
              <div class="heading3 text-center space-margin60">
                  <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>Our Leadership</span></h5>
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
                      <a href="#contact" class="title">Mr. Abdullah Barakah Ali Al-Safari Al-Harby</a>
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
                      <a href="#contact" class="title">Mr. Mohammad Awad Al-Harby</a>
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
                      <a href="#contact" class="title">Mr. Tasawar Mahmood</a>
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

<!--===== PRICING AREA STARTS =======-->
<div class="pricing1 sp2 common-bg">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 m-auto">
              <div class="heading3 text-center space-margin60">
                 <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>Our Projects</span></h5>
            <div class="space16"></div>
                 <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Major Projects Completed Across Saudi Arabia</h2>
          </div>
      </div>
    </div>

      <div class="row">
          <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
              <div class="pricing-box">
                  <h3>Haram Makkah Projects</h3>
          <div class="space24"></div>
                  <h2>600+<span>Escalators</span></h2>
          <div class="space24"></div>
                  <p>Completed escalator cladding projects for the Holy Haram in Makkah, including Clock Tower and surrounding areas.</p>
                  <div class="space24"></div>
                  <h3>Featured Included:</h3>
                  <div class="space8"></div>
                  <ul>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Energy efficiency consultation</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331a" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331a">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Reliable electricity for small</li>
                      <li> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331b" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331b">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Add solar panel integration</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331c" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331c">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>24/7 technical support</li>
                  </ul>
                  <div class="space32"></div>
                  <div class="bnt-area1">
                      <a href="{{ route('contact') }}" class="vl-btn1">Choose A Plan <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
              <div class="pricing-box active">
                  <h3>Major Shopping Malls</h3>
          <div class="space24"></div>
                  <h2>200+<span>Elevators</span></h2>
                  <div class="space24"></div>
                  <p>Elevator cabin and door cladding for major shopping malls including Star Avenue, Zahra Mall, and Lulu Harmain.</p>
                  <div class="space24"></div>
                  <h3>Featured Included:</h3>
                  <div class="space8"></div>
                  <ul>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                          <g clip-path="url(#clip0_3136_57402)">
                              <mask id="mask0_3136_57402" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                              <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                              <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                              </mask>
                              <g mask="url(#mask0_3136_57402)">
                              <path d="M0 0H20V20H0V0Z" fill="white"/>
                              </g>
                          </g>
                          <defs>
                              <clipPath id="clip0_3136_57402">
                              <rect width="20" height="20" fill="white"/>
                              </clipPath>
                          </defs>
                          </svg>Add solar or wind energy integration</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57402)">
                          <mask id="mask0_3136_57402d" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57402)">
                          <path d="M0 0H20V20H0V0Z" fill="white"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57402d">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Energy usage analytics to optimize</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57402)">
                          <mask id="mask0_3136_57402e" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57402)">
                          <path d="M0 0H20V20H0V0Z" fill="white"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57402e">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Reliable power for small offices</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57402)">
                          <mask id="mask0_3136_57402f" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57402)">
                          <path d="M0 0H20V20H0V0Z" fill="white"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57402f">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>24/7 emergency support</li>
                  </ul>
                  <div class="space32"></div>
                  <div class="bnt-area1">
                      <a href="{{ route('contact') }}" class="vl-btn1">Choose A Plan <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
              <div class="pricing-box">
                  <h3>Universities & Hospitals</h3>
          <div class="space24"></div>
                  <h2>50+<span>Projects</span></h2>
                  <div class="space24"></div>
                  <p>Steel fabrication and elevator solutions for King Saud University, KAUST, and major hospitals across the Kingdom.</p>
                  <div class="space24"></div>
                  <h3>Featured Included:</h3>
                  <div class="space8"></div>
                  <ul>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331g" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331g">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>High-capacity power manufacturing</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331i" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331i">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Custom renewable energy solutions</li>
                      <li> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331j" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331j">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>Smart grid technology for peak</li>
                      <li><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                      <g clip-path="url(#clip0_3136_57331)">
                          <mask id="mask0_3136_57331k" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                          <path d="M9.9974 18.3346C11.092 18.3361 12.176 18.1212 13.1872 17.7023C14.1985 17.2834 15.117 16.6688 15.8899 15.8938C16.6649 15.1209 17.2795 14.2024 17.6984 13.1911C18.1172 12.1799 18.3322 11.0959 18.3307 10.0013C18.3321 8.90676 18.1172 7.82272 17.6983 6.81149C17.2795 5.80026 16.6649 4.88177 15.8899 4.10881C15.117 3.33382 14.1985 2.71923 13.1872 2.30034C12.176 1.88146 11.092 1.66656 9.9974 1.66798C8.90285 1.66658 7.81881 1.8815 6.80758 2.30038C5.79635 2.71926 4.87786 3.33384 4.1049 4.10881C3.32993 4.88177 2.71535 5.80026 2.29647 6.81149C1.87759 7.82272 1.66267 8.90676 1.66407 10.0013C1.66265 11.0959 1.87756 12.1799 2.29644 13.1911C2.71532 14.2024 3.32991 15.1209 4.1049 15.8938C4.87786 16.6688 5.79635 17.2834 6.80758 17.7022C7.81881 18.1211 8.90285 18.336 9.9974 18.3346Z" fill="white" stroke="white" stroke-width="1.66667" stroke-linejoin="round"/>
                          <path d="M6.66406 10L9.16406 12.5L14.1641 7.5" stroke="black" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                          </mask>
                          <g mask="url(#mask0_3136_57331)">
                          <path d="M0 0H20V20H0V0Z" fill="#0F0D0D"/>
                          </g>
                      </g>
                      <defs>
                          <clipPath id="clip0_3136_57331k">
                          <rect width="20" height="20" fill="white"/>
                          </clipPath>
                      </defs>
                      </svg>24/7 technical support</li>
                  </ul>
                  <div class="space32"></div>
                  <div class="bnt-area1">
                      <a href="{{ route('contact') }}" class="vl-btn1">Choose A Plan <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--===== PRICING AREA ENDS =======-->

<!--===== BLOG AREA STARTS =======-->
<div class="vl-blog-5-area sp2">
  <div class="container">
     <div class="row">
        <div class="col-xl-6 m-auto">
         <div class="heading3 text-center space-margin60">
          <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements12.png') }}" alt=""> <span>OUR CAPABILITIES</span></h5>
            <div class="space16"></div>
          <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Steel Fabrication Excellence & Innovation</h2>
          </div>
        </div>
     </div>
     <div class="row">
    <div class="col-xl-6 col-md-6" data-aos="fade-left" data-aos-duration="900">
        <div class="vl-blog-1-item">
           <div class="vl-blog-1-thumb image-anime">
            <img src="{{ asset('assets/pdf-images/img124.jpg') }}" alt="">
           </div>
           <div class="vl-blog-1-content">
            <div class="vl-blog-meta">
               <ul>
                <li>
                  <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                  <path d="M6.33333 9.16797H8V10.8346H6.33333V9.16797ZM18 5.0013V16.668C18 17.5846 17.25 18.3346 16.3333 18.3346H4.66667C4.22464 18.3346 3.80072 18.159 3.48816 17.8465C3.17559 17.5339 3 17.11 3 16.668L3.00833 5.0013C3.00833 4.08464 3.74167 3.33464 4.66667 3.33464H5.5V1.66797H7.16667V3.33464H13.8333V1.66797H15.5V3.33464H16.3333C17.25 3.33464 18 4.08464 18 5.0013ZM4.66667 6.66797H16.3333V5.0013H4.66667V6.66797ZM16.3333 16.668V8.33464H4.66667V16.668H16.3333ZM13 10.8346H14.6667V9.16797H13V10.8346ZM9.66667 10.8346H11.3333V9.16797H9.66667V10.8346Z" fill="#0F0D0D"/>
                </svg> Jan 24, 2025</a>
              </li>

              <li>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                <path d="M2.58588 17.5949C2.58648 17.6376 2.59548 17.6797 2.61237 17.7189C2.62926 17.7581 2.6537 17.7936 2.68431 17.8234C2.71491 17.8531 2.75108 17.8766 2.79074 17.8923C2.8304 17.9081 2.87279 17.9159 2.91547 17.9153H18.085C18.1278 17.916 18.1702 17.9082 18.2099 17.8925C18.2496 17.8767 18.2858 17.8533 18.3165 17.8235C18.3471 17.7938 18.3716 17.7583 18.3885 17.719C18.4054 17.6798 18.4145 17.6376 18.415 17.5949V17.2124C18.4225 17.097 18.438 16.522 18.0588 15.8857C17.8196 15.4845 17.4725 15.1382 17.0271 14.8557C16.4884 14.5141 15.803 14.267 14.9738 14.1182C14.5529 14.059 14.1354 13.9778 13.723 13.8749C12.6263 13.5949 12.5305 13.347 12.5296 13.3445C12.5233 13.32 12.5141 13.2964 12.5021 13.2741C12.493 13.2282 12.4709 13.0541 12.5134 12.5878C12.6209 11.4032 13.2563 10.7032 13.7667 10.1407C13.9276 9.96365 14.0796 9.79574 14.1967 9.63157C14.7021 8.92324 14.7488 8.11699 14.7509 8.06699C14.7528 7.97839 14.7406 7.89006 14.7146 7.80532C14.6646 7.65115 14.5717 7.55532 14.5034 7.48449C14.4872 7.46827 14.4715 7.4516 14.4563 7.43449C14.4513 7.42865 14.438 7.41282 14.4501 7.33324C14.4909 7.07686 14.5191 6.81863 14.5346 6.55949C14.558 6.14199 14.5759 5.51782 14.468 4.9099C14.4521 4.79379 14.4282 4.67892 14.3963 4.56615C14.2825 4.14782 14.1001 3.79032 13.8463 3.49532C13.8026 3.4474 12.7409 2.32865 9.6588 2.09949C9.23255 2.06782 8.8113 2.0849 8.3963 2.10615C8.27357 2.10888 8.15143 2.12396 8.03172 2.15115C7.71338 2.23324 7.62838 2.4349 7.6063 2.54782C7.56922 2.73532 7.63422 2.88032 7.67713 2.97699C7.68338 2.99074 7.6913 3.00782 7.67755 3.05282C7.6063 3.16365 7.49338 3.26365 7.3788 3.35824C7.34547 3.38615 6.57297 4.05282 6.53047 4.92324C6.41588 5.58532 6.42422 6.61657 6.55963 7.32949C6.56797 7.36907 6.57922 7.4274 6.56047 7.46699C6.41463 7.5974 6.24963 7.74532 6.25005 8.08282C6.25172 8.11699 6.2988 8.92282 6.80422 9.63157C6.92088 9.79574 7.07297 9.96324 7.23338 10.1403L7.23422 10.1407C7.74463 10.7032 8.38005 11.4032 8.48755 12.5874C8.52963 13.0541 8.50755 13.2278 8.4988 13.2741C8.4867 13.2963 8.47733 13.32 8.47088 13.3445C8.47047 13.347 8.37505 13.5941 7.28338 13.8737C6.65338 14.0349 6.03338 14.1174 6.01463 14.1195C5.2088 14.2557 4.52755 14.497 3.98963 14.8366C3.54588 15.117 3.19797 15.4645 2.9563 15.8687C2.56963 16.5145 2.58005 17.1028 2.58547 17.2103V17.5949H2.58588Z" stroke="#0F0D0D" stroke-width="1.66667" stroke-linejoin="round"/>
              </svg> Joshua Jones</a>
            </li>
               </ul>
            </div>
            <div class="space18"></div>
          <h4 class="vl-blog-1-title"><a href="#services">Elevator & Escalator Cladding Expertise</a></h4>
            <div class="space12"></div>
          <p>With over 20 years of experience, Alsafri specializes in stainless steel cladding for escalators and elevators, serving major companies like Kone, Fujitec, Schindler, and Otis across Saudi Arabia.</p>
            <div class="space24"></div>
            <div class="vl-blog-1-icon">
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
           </div>
         </div>
        </div>
     </div>

   <div class="col-xl-6 col-md-6" data-aos="fade-left" data-aos-duration="1000">
        <div class="vl-blog-1-item">
           <div class="vl-blog-1-thumb image-anime">
            <img src="{{ asset('assets/pdf-images/img125.jpg') }}" alt="">
           </div>
           <div class="vl-blog-1-content">
            <div class="vl-blog-meta">
              <ul>
                <li>
                  <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                  <path d="M6.33333 9.16797H8V10.8346H6.33333V9.16797ZM18 5.0013V16.668C18 17.5846 17.25 18.3346 16.3333 18.3346H4.66667C4.22464 18.3346 3.80072 18.159 3.48816 17.8465C3.17559 17.5339 3 17.11 3 16.668L3.00833 5.0013C3.00833 4.08464 3.74167 3.33464 4.66667 3.33464H5.5V1.66797H7.16667V3.33464H13.8333V1.66797H15.5V3.33464H16.3333C17.25 3.33464 18 4.08464 18 5.0013ZM4.66667 6.66797H16.3333V5.0013H4.66667V6.66797ZM16.3333 16.668V8.33464H4.66667V16.668H16.3333ZM13 10.8346H14.6667V9.16797H13V10.8346ZM9.66667 10.8346H11.3333V9.16797H9.66667V10.8346Z" fill="#0F0D0D"/>
                </svg> Jan 22, 2025</a>
              </li>

              <li>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                <path d="M2.58588 17.5949C2.58648 17.6376 2.59548 17.6797 2.61237 17.7189C2.62926 17.7581 2.6537 17.7936 2.68431 17.8234C2.71491 17.8531 2.75108 17.8766 2.79074 17.8923C2.8304 17.9081 2.87279 17.9159 2.91547 17.9153H18.085C18.1278 17.916 18.1702 17.9082 18.2099 17.8925C18.2496 17.8767 18.2858 17.8533 18.3165 17.8235C18.3471 17.7938 18.3716 17.7583 18.3885 17.719C18.4054 17.6798 18.4145 17.6376 18.415 17.5949V17.2124C18.4225 17.097 18.438 16.522 18.0588 15.8857C17.8196 15.4845 17.4725 15.1382 17.0271 14.8557C16.4884 14.5141 15.803 14.267 14.9738 14.1182C14.5529 14.059 14.1354 13.9778 13.723 13.8749C12.6263 13.5949 12.5305 13.347 12.5296 13.3445C12.5233 13.32 12.5141 13.2964 12.5021 13.2741C12.493 13.2282 12.4709 13.0541 12.5134 12.5878C12.6209 11.4032 13.2563 10.7032 13.7667 10.1407C13.9276 9.96365 14.0796 9.79574 14.1967 9.63157C14.7021 8.92324 14.7488 8.11699 14.7509 8.06699C14.7528 7.97839 14.7406 7.89006 14.7146 7.80532C14.6646 7.65115 14.5717 7.55532 14.5034 7.48449C14.4872 7.46827 14.4715 7.4516 14.4563 7.43449C14.4513 7.42865 14.438 7.41282 14.4501 7.33324C14.4909 7.07686 14.5191 6.81863 14.5346 6.55949C14.558 6.14199 14.5759 5.51782 14.468 4.9099C14.4521 4.79379 14.4282 4.67892 14.3963 4.56615C14.2825 4.14782 14.1001 3.79032 13.8463 3.49532C13.8026 3.4474 12.7409 2.32865 9.6588 2.09949C9.23255 2.06782 8.8113 2.0849 8.3963 2.10615C8.27357 2.10888 8.15143 2.12396 8.03172 2.15115C7.71338 2.23324 7.62838 2.4349 7.6063 2.54782C7.56922 2.73532 7.63422 2.88032 7.67713 2.97699C7.68338 2.99074 7.6913 3.00782 7.67755 3.05282C7.6063 3.16365 7.49338 3.26365 7.3788 3.35824C7.34547 3.38615 6.57297 4.05282 6.53047 4.92324C6.41588 5.58532 6.42422 6.61657 6.55963 7.32949C6.56797 7.36907 6.57922 7.4274 6.56047 7.46699C6.41463 7.5974 6.24963 7.74532 6.25005 8.08282C6.25172 8.11699 6.2988 8.92282 6.80422 9.63157C6.92088 9.79574 7.07297 9.96324 7.23338 10.1403L7.23422 10.1407C7.74463 10.7032 8.38005 11.4032 8.48755 12.5874C8.52963 13.0541 8.50755 13.2278 8.4988 13.2741C8.4867 13.2963 8.47733 13.32 8.47088 13.3445C8.47047 13.347 8.37505 13.5941 7.28338 13.8737C6.65338 14.0349 6.03338 14.1174 6.01463 14.1195C5.2088 14.2557 4.52755 14.497 3.98963 14.8366C3.54588 15.117 3.19797 15.4645 2.9563 15.8687C2.56963 16.5145 2.58005 17.1028 2.58547 17.2103V17.5949H2.58588Z" stroke="#0F0D0D" stroke-width="1.66667" stroke-linejoin="round"/>
              </svg> Eddie Lake</a>
            </li>
               </ul>
            </div>
            <div class="space18"></div>
          <h4 class="vl-blog-1-title"><a href="#services">Comprehensive Steel Fabrication Services</a></h4>
            <div class="space12"></div>
          <p>From mild steel structures and handrails to water tanks and custom fabrication jobs, we provide complete steel fabrication solutions tailored to meet your specific project requirements.</p>
            <div class="space24"></div>
            <div class="vl-blog-1-icon">
            <a href="{{ route('contact') }}" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
           </div>
         </div>
        </div>
     </div>
         </div>
  </div>
</div>
<!--===== BLOG AREA ENDS =======-->

@endsection