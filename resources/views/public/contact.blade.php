@extends('public.layout')
@section('title', 'Contact Us - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center p-5">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>Contact Us</h1>
                    <div class="space16"></div>
                    <a href="{{route('home')}}">Home <i class="fa-solid fa-angle-right"></i> <span>Contact Us</span></a>
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

<!--===== CONTACT AREA STARTS =======-->
<div class="contact-widget-sec sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="contact-widget-box">
                    <p>Need expert guidance on steel fabrication and elevator solutions? We're here to help! Reach out to our team for personalized assistance with your projects.</p>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="contact-widget-small">
                                <div class="icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M13.9985 24.5857C18.0699 18.8857 21.3271 14 21.3271 10.7429C21.3271 8.79922 20.5549 6.93517 19.1806 5.5608C17.8062 4.18642 15.9422 3.41431 13.9985 3.41431C12.0548 3.41431 10.1908 4.18642 8.81641 5.5608C7.44204 6.93517 6.66992 8.79922 6.66992 10.7429C6.66992 14 9.92706 18.8857 13.9985 24.5857Z" stroke="white" stroke-width="2"/>
                                    <path d="M17.2565 10.7429C17.2565 11.6067 16.9133 12.4352 16.3025 13.046C15.6916 13.6568 14.8632 14 13.9993 14C13.1355 14 12.307 13.6568 11.6962 13.046C11.0853 12.4352 10.7422 11.6067 10.7422 10.7429C10.7422 9.87901 11.0853 9.05055 11.6962 8.43971C12.307 7.82888 13.1355 7.48572 13.9993 7.48572C14.8632 7.48572 15.6916 7.82888 16.3025 8.43971C16.9133 9.05055 17.2565 9.87901 17.2565 10.7429Z" stroke="white" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div class="space24"></div>
                                <h5>Office Address</h5>
                                <div class="space12"></div>
                                <a href="#">P.O. Box: 23717, Al-Johrah Distt., Jeddah 21436, Saudi Arabia</a>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="contact-widget-small">
                                <div class="icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M13.9985 24.5857C18.0699 18.8857 21.3271 14 21.3271 10.7429C21.3271 8.79922 20.5549 6.93517 19.1806 5.5608C17.8062 4.18642 15.9422 3.41431 13.9985 3.41431C12.0548 3.41431 10.1908 4.18642 8.81641 5.5608C7.44204 6.93517 6.66992 8.79922 6.66992 10.7429C6.66992 14 9.92706 18.8857 13.9985 24.5857Z" stroke="white" stroke-width="2"/>
                                    <path d="M17.2565 10.7429C17.2565 11.6067 16.9133 12.4352 16.3025 13.046C15.6916 13.6568 14.8632 14 13.9993 14C13.1355 14 12.307 13.6568 11.6962 13.046C11.0853 12.4352 10.7422 11.6067 10.7422 10.7429C10.7422 9.87901 11.0853 9.05055 11.6962 8.43971C12.307 7.82888 13.1355 7.48572 13.9993 7.48572C14.8632 7.48572 15.6916 7.82888 16.3025 8.43971C16.9133 9.05055 17.2565 9.87901 17.2565 10.7429Z" stroke="white" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div class="space24"></div>
                                <h5>Email Address</h5>
                                <div class="space12"></div>
                                <a href="mailto:alsafri4u@gmail.com">alsafri4u@gmail.com <br>info@alsafri.com</a>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="contact-widget-small">
                                <div class="icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M13.9985 24.5857C18.0699 18.8857 21.3271 14 21.3271 10.7429C21.3271 8.79922 20.5549 6.93517 19.1806 5.5608C17.8062 4.18642 15.9422 3.41431 13.9985 3.41431C12.0548 3.41431 10.1908 4.18642 8.81641 5.5608C7.44204 6.93517 6.66992 8.79922 6.66992 10.7429C6.66992 14 9.92706 18.8857 13.9985 24.5857Z" stroke="white" stroke-width="2"/>
                                    <path d="M17.2565 10.7429C17.2565 11.6067 16.9133 12.4352 16.3025 13.046C15.6916 13.6568 14.8632 14 13.9993 14C13.1355 14 12.307 13.6568 11.6962 13.046C11.0853 12.4352 10.7422 11.6067 10.7422 10.7429C10.7422 9.87901 11.0853 9.05055 11.6962 8.43971C12.307 7.82888 13.1355 7.48572 13.9993 7.48572C14.8632 7.48572 15.6916 7.82888 16.3025 8.43971C16.9133 9.05055 17.2565 9.87901 17.2565 10.7429Z" stroke="white" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div class="space24"></div>
                                <h5>Call Us</h5>
                                <div class="space12"></div>
                                <a href="tel:+966-2-2898225">+966-2-2898225 <br>+966-2-2160900</a>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="contact-widget-small">
                                <h5>Office Address</h5>
                                <div class="space24"></div>
                                <ul>
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-xl-6">
                <div class="space30 d-xl-none d-block"></div>
                <div class=" contact-widget-area-inner heading1">
                    <h4 data-aos="fade-left" data-aos-duration="900">Send us a Message</h4>
                    <div class="space12"></div>
                    <p data-aos="fade-left" data-aos-duration="1100">We're here to support you every step of the way. Whether you have questions about our steel fabrication services, need assistance with elevator cladding projects, or want to discuss your custom fabrication requirements.</p>
                    <div class="space12"></div>
                    <div class="contact-boxarea" data-aos="fade-left" data-aos-duration="1200">
                        <form id="contact-form">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <div class="input-area">
                                        <input type="text" name="name" id="contact-name" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="input-area">
                                        <input type="email" name="email" id="contact-email" placeholder="Email" required>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <div class="input-area">
                                        <select name="subject" id="contact-subject" class="country-area nice-select">
                                            <option value="" data-display="Subject?">Subject</option>
                                            <option value="Elevator & Escalator Cladding">Elevator & Escalator Cladding</option>
                                            <option value="Steel Fabrication & Structures">Steel Fabrication & Structures</option>
                                            <option value="Water Tanks & Custom Fabrication">Water Tanks & Custom Fabrication</option>
                                            <option value="Steel Brackets & Accessories">Steel Brackets & Accessories</option>
                                            <option value="General Fabrication Jobs">General Fabrication Jobs</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <div class="input-area">
                                        <textarea name="message" id="contact-message" placeholder="How can we help you?" required></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12">
                                    <div class="input-area">
                                        <button type="submit" class="vl-btn1">Send Now <i class="fa-solid fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="contact-message-alert" style="margin-top: 15px; display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="maps-widget-area">
 <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3730.598746037369!2d39.316838!3d21.536326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjHCsDMyJzEwLjgiTiAzOcKwMTknMDAuNiJF!5e1!3m2!1sen!2s!4v1761337212150!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!--===== CONTACT AREA ENDS =======-->

@endsection