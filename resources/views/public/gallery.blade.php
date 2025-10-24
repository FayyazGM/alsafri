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
                    <a href="{{ route('home') }}">Home <i class="fa-solid fa-angle-right"></i> <span>Gallery</span></a>
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
                    <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>GALLERY</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                    <div class="space16"></div>
                    <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Showcasing Our Steel Fabrication Excellence</h2>
                    <div class="space16"></div>
                    <p data-aos="zoom-in-up" data-aos-duration="1100">Explore our portfolio of completed projects including elevator cladding, escalator installations, steel structures, and custom fabrication work across Saudi Arabia.</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($galleryImages as $image)
                <div class="col-xl-4 col-md-6">
                    <div class="projects-boxes-area">
                        <div class="img1">
                            <img src="{{ $image->image_url }}" alt="{{ $image->title }}">
                        </div>
                        <div class="contain-main-area">
                            <div class="content-p-area">
                                <span>{{ ucfirst(str_replace('_', ' ', $image->category)) }}</span>
                                <div class="space12"></div>
                                <a href="{{ $image->image_url }}" class="title" data-lightbox="gallery">{{ $image->title }}</a>
                            </div>
                            <div class="arrow">
                                <a href="{{ $image->image_url }}" data-lightbox="gallery"><i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No gallery images available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="col-xl-12">
            <div class="space18"></div>
            <div class="pagination-area">
                {{ $galleryImages->links() }}
            </div>
        </div>
    </div>
</div>
<!--===== GALLERY AREA ENDS =======-->
@endsection

@section('custom-css')
<style>
/* Gallery Image Symmetry Fix */
.projects-boxes-area {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.projects-boxes-area .img1 {
    height: 250px;
    overflow: hidden;
    position: relative;
}

.projects-boxes-area .img1 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
}

.projects-boxes-area:hover .img1 img {
    transform: scale(1.05);
}

.contain-main-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-top: none;
}

.content-p-area {
    flex: 1;
}

.content-p-area span {
    display: inline-block;
    background: #007bff;
    color: #fff;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.content-p-area .title {
    display: block;
    color: #333;
    font-weight: 600;
    font-size: 16px;
    line-height: 1.4;
    margin-top: 12px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.content-p-area .title:hover {
    color: #007bff;
}

.arrow {
    margin-top: 15px;
    text-align: right;
}

.arrow a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #007bff;
    color: #fff;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.arrow a:hover {
    background: #0056b3;
    transform: translateX(5px);
}

/* Ensure equal height for all gallery items */
.row .col-xl-4 {
    display: flex;
    margin-bottom: 30px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .projects-boxes-area .img1 {
        height: 200px;
    }
    
    .contain-main-area {
        padding: 15px;
    }
    
    .content-p-area .title {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .projects-boxes-area .img1 {
        height: 180px;
    }
    
    .contain-main-area {
        padding: 12px;
    }
}
</style>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    // Initialize lightbox for gallery images
    if (typeof $.fn.magnificPopup !== 'undefined') {
        $('a[data-lightbox="gallery"]').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1]
            },
            image: {
                titleSrc: function(item) {
                    return item.el.find('.title').text();
                }
            }
        });
    }
});
</script>
@endsection