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
                    <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>Our Services</span></a>
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
            <a href="service-single.html" class="title">Elevator & Escalator Cladding Services</a>
            <div class="space16"></div>
            <p>We specialize in stainless steel cladding of escalators and elevators, dismantling and installation services, and accessories for elevators across Saudi Arabia.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Steel Fabrication & Structures</a>
            <div class="space16"></div>
            <p>We provide comprehensive steel fabrication services including mild steel structures, handrails for staircases, sliding gates, and custom fabrication jobs as per client specifications.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Water Tanks & Custom Fabrication</a>
            <div class="space16"></div>
            <p>We specialize in stainless steel and mild steel water tanks, custom fabrication jobs, and supply of raw materials including angles, tubes, and steel sheets.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Commercial & Residential Electrical Services</a>
            <div class="space16"></div>
            <p>We provide personalized energy solutions for homeowners, businesses, & industries ensuring that you have the most efficient.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Comprehensive Energy Solutions for Every Need</a>
            <div class="space16"></div>
            <p>VOLTZ provides custom energy solutions that enhance efficiency, lower costs, and promote sustainability.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Sustainable Energy Financing & Consulting</a>
            <div class="space16"></div>
            <p>With rising energy costs and increasing demand for sustainability, VOLTZ is here to help you take control of your energy.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Commercial & Residential Electrical Services</a>
            <div class="space16"></div>
            <p>We provide personalized energy solutions for homeowners, businesses, & industries ensuring that you have the most efficient.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Comprehensive Energy Solutions for Every Need</a>
            <div class="space16"></div>
            <p>VOLTZ provides custom energy solutions that enhance efficiency, lower costs, and promote sustainability.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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
            <a href="service-single.html" class="title">Sustainable Energy Financing & Consulting</a>
            <div class="space16"></div>
            <p>With rising energy costs and increasing demand for sustainability, VOLTZ is here to help you take control of your energy.</p>
            <div class="space24"></div>
            <a href="service-single.html" class="readmore">Learn More <i class="fa-solid fa-arrow-right"></i></a>
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

<!--===== CONTACT AREA STARTS =======-->
<div class="contact2 sp1">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 m-auto">
          <div class="heading1 text-center space-margin60">
            <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""><span>CONTACT US</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
            <div class="space16"></div>
            <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Your Clean Energy Journey Begins Now</h2>
          </div>
        </div>
      </div>
        <div class="row">
            <div class="col-xl-6" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="contact-maps-area">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
              </div>

                <div class="col-xl-6">
                <div class=" contact-widget-area heading3">
                    <h4 data-aos="fade-left" data-aos-duration="900">Send us a Message</h4>
                    <div class="space12"></div>
                    <p data-aos="fade-left" data-aos-duration="1100">Weâre here to support you every step of the way. Whether you questions about our services, need assistance with a cybersecurity challenge.</p>
                    <div class="space12"></div>
                    <div class="contact-boxarea" data-aos="fade-left" data-aos-duration="1200">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="input-area">
                                    <input type="text" placeholder="Full Name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="input-area">
                                    <input type="email" placeholder="Email">
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="input-area">
                                    <select name="country" id="country" class="country-area nice-select">
                                        <option value="1" data-display="Subject?">Subject</option>
                                        <option value=""> General Medical Services</option>
                                        <option value=""> Specialist Services</option>
                                        <option value=""> Womenâs Health Services</option>
                                        <option value=""> Mental Health and Wellness</option>
                                        <option value=""> Diagnostic and Laboratory Services</option>
                                      </select>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="input-area">
                                    <textarea placeholder="How can we help you?"></textarea>
                                </div>
                            </div>

                            <div class="col-xl-12 col-md-12">
                                <div class="input-area">
                                    <button type="submit" class="vl-btn1">Send Now <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT AREA ENDS =======-->
<div class="space100 d-lg-block d-none"></div>
<div class="space100 d-lg-none d-block"></div>
<!--===== CTA AREA STARTS =======-->
<div class="cta1-aection-area">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="cta-bg-area">
          <img src="{{ asset('assets/img/elements/elements4.png') }}" alt="" class="elements4">
          <div class="row align-items-center">
            <div class="col-xl-6">
              <div class="cta-heading">
                <h2 data-aos="zoom-in" data-aos-duration="800">Secure Reliable Power for Your Home and Business!</h2>
                <div class="space16"></div>
                <p data-aos="zoom-in" data-aos-duration="900">No more blackouts, no more energy worries! VOLTZ ensures you have uninterrupted, high-quality power whenever you need it. Get a free!</p>
                <div class="space32"></div>
                <div class="form-area" data-aos="zoom-in" data-aos-duration="1100">
                  <form>
                    <input type="text" placeholder="Your Email Address">
                    <button class="vl-btn1" type="submit">Subscribe <i class="fa-solid fa-arrow-right"></i></button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-xl-1"></div>
              <div class="col-xl-5" data-aos="zoom-in" data-aos-duration="1000">
              <div class="cta-images-area text-end">
                <img src="{{ asset('assets/img/all-images/cta/cta-img1.png') }}" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== CTA AREA ENDS =======-->
@endsection