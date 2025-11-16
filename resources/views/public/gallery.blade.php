@extends('public.layout')
@section('title', 'Gallery - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center p-5">
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
                    {{-- <div class="img1">
                        <img src="{{ asset('assets/img/all-images/hero/hero-img9.png') }}" alt="">
                    </div> --}}
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

        <!-- Category Filter -->
        <div class="row">
            <div class="col-xl-12">
                <div class="gallery-filter-wrapper" data-aos="fade-up" data-aos-duration="800">
                    <div class="filter-header-text">
                        <h3><i class="fa-solid fa-filter"></i> Filter by Category</h3>
                    </div>
                    <div class="filter-buttons-container">
                        <a href="{{ route('gallery', ['category' => 'all']) }}" 
                           class="filter-btn {{ ($selectedCategory ?? 'all') == 'all' ? 'active' : '' }}">
                            <i class="fa-solid fa-th"></i>
                            <span>All Projects</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('gallery', ['category' => $category]) }}" 
                               class="filter-btn {{ ($selectedCategory ?? 'all') == $category ? 'active' : '' }}">
                                <i class="fa-solid fa-folder"></i>
                                <span>{{ ucfirst(str_replace(['_', '-'], ' ', $category)) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row gallery-grid" id="gallery-grid">
            @forelse($galleryImages as $image)
                <div class="col-xl-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $loop->index * 100 }}" data-category="{{ $image->category }}">
                    <div class="gallery-card-modern">
                        <div class="gallery-image-container">
                            <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="gallery-img">
                            <div class="gallery-overlay-modern">
                                <div class="gallery-actions">
                                    <a href="{{ $image->image_url }}" class="gallery-action-btn" data-lightbox="gallery" title="View Full Size">
                                        <i class="fa-solid fa-expand"></i>
                                    </a>
                                    <a href="{{ $image->image_url }}" class="gallery-action-btn" data-lightbox="gallery" title="View Image">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="gallery-category-tag">
                                <i class="fa-solid fa-tag"></i>
                                <span>{{ ucfirst(str_replace(['_', '-'], ' ', $image->category)) }}</span>
                            </div>
                        </div>
                        <div class="gallery-card-body">
                            <h4 class="gallery-item-title">
                                <a href="{{ $image->image_url }}" data-lightbox="gallery">{{ $image->title }}</a>
                            </h4>
                            @if($image->description)
                                <p class="gallery-item-desc">{{ \Illuminate\Support\Str::limit($image->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-gallery-state" data-aos="fade-up" data-aos-duration="1000">
                        <div class="empty-gallery-icon">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <h3>No Gallery Images Available</h3>
                        <p>We're currently updating our gallery. Please check back soon!</p>
                    </div>
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
/* ============================================
   MODERN GALLERY PAGE - COMPLETE REDESIGN
   ============================================ */

/* ============================================
   BEAUTIFUL CATEGORIES SECTION - PREMIUM DESIGN
   ============================================ */

.gallery-filter-wrapper {
    margin: 50px 0 60px;
    padding: 0;
    background: transparent;
    border-radius: 0;
    box-shadow: none;
    border: none;
    position: relative;
}

/* Beautiful Header Section */
.filter-header-text {
    margin-bottom: 35px;
    text-align: center;
    position: relative;
    padding-bottom: 20px;
}

.filter-header-text::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #ba9269 0%, #9a7a4f 100%);
    border-radius: 2px;
}

.filter-header-text h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #2c3e50 0%, #ba9269 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    letter-spacing: -0.5px;
}

.filter-header-text h3 i {
    color: #ba9269;
    font-size: 30px;
    background: linear-gradient(135deg, #ba9269 0%, #9a7a4f 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

/* Beautiful Buttons Container */
.filter-buttons-container {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    justify-content: center;
    align-items: center;
    padding: 30px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%);
    border-radius: 25px;
    box-shadow: 
        0 10px 40px rgba(0, 0, 0, 0.08),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(186, 146, 105, 0.08);
    position: relative;
    overflow: hidden;
}

.filter-buttons-container::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(186, 146, 105, 0.03) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Premium Filter Buttons */
.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    color: #495057;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 15px;
    text-transform: capitalize;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid #e9ecef;
    cursor: pointer;
    white-space: nowrap;
    box-shadow: 
        0 4px 15px rgba(0, 0, 0, 0.08),
        0 2px 5px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    z-index: 1;
    letter-spacing: 0.3px;
}

.filter-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.6s ease;
}

.filter-btn:hover::before {
    left: 100%;
}

.filter-btn::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(186, 146, 105, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
    z-index: -1;
}

.filter-btn:hover::after {
    width: 300px;
    height: 300px;
}

.filter-btn i {
    font-size: 18px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2;
    color: #ba9269;
}

.filter-btn span {
    position: relative;
    z-index: 2;
}

.filter-btn:hover {
    color: #ba9269;
    border-color: #ba9269;
    background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
    transform: translateY(-5px) scale(1.02);
    box-shadow: 
        0 12px 35px rgba(186, 146, 105, 0.25),
        0 5px 15px rgba(186, 146, 105, 0.15);
}

.filter-btn:hover i {
    transform: scale(1.25) rotate(10deg);
    color: #9a7a4f;
}

.filter-btn.active {
    background: linear-gradient(135deg, #ba9269 0%, #9a7a4f 100%);
    color: #ffffff;
    border-color: #ba9269;
    box-shadow: 
        0 12px 35px rgba(186, 146, 105, 0.4),
        0 5px 15px rgba(186, 146, 105, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    transform: translateY(-5px) scale(1.05);
    position: relative;
}

.filter-btn.active::before {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
}

.filter-btn.active::after {
    background: rgba(255, 255, 255, 0.15);
    width: 300px;
    height: 300px;
}

.filter-btn.active i {
    transform: scale(1.2);
    color: #ffffff;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.filter-btn.active span {
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

/* Modern Gallery Cards - Premium Design */
.gallery-grid {
    margin-top: 20px;
}

.gallery-card-modern {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    border: 1px solid #f0f0f0;
}

.gallery-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(186, 146, 105, 0.2);
    border-color: #ba9269;
}

.gallery-image-container {
    position: relative;
    overflow: hidden;
    height: 280px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-card-modern:hover .gallery-img {
    transform: scale(1.12);
}

.gallery-overlay-modern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(186, 146, 105, 0.9) 0%, rgba(154, 122, 79, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.gallery-card-modern:hover .gallery-overlay-modern {
    opacity: 1;
}

.gallery-actions {
    display: flex;
    gap: 15px;
    align-items: center;
}

.gallery-action-btn {
    width: 55px;
    height: 55px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ba9269;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 18px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    transform: scale(0.8);
}

.gallery-card-modern:hover .gallery-action-btn {
    transform: scale(1);
}

.gallery-action-btn:hover {
    background: #ffffff;
    color: #ba9269;
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.gallery-category-tag {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 3;
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(186, 146, 105, 0.95);
    backdrop-filter: blur(10px);
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
    box-shadow: 0 4px 15px rgba(186, 146, 105, 0.3);
    transition: all 0.3s ease;
}

.gallery-category-tag i {
    font-size: 11px;
}

.gallery-card-modern:hover .gallery-category-tag {
    background: rgba(154, 122, 79, 0.95);
    transform: scale(1.05);
}

.gallery-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ffffff;
}

.gallery-item-title {
    margin: 0 0 12px 0;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    color: #2c3e50;
}

.gallery-item-title a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.gallery-item-title a:hover {
    color: #ba9269;
}

.gallery-item-desc {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.7;
    margin: 0;
    flex: 1;
}

/* Empty State - Modern Design */
.empty-gallery-state {
    text-align: center;
    padding: 100px 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.empty-gallery-icon {
    font-size: 100px;
    color: #dee2e6;
    margin-bottom: 30px;
    opacity: 0.6;
}

.empty-gallery-state h3 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
}

.empty-gallery-state p {
    color: #6c757d;
    font-size: 16px;
    margin: 0;
}

/* ============================================
   BEAUTIFUL PAGINATION - PREMIUM DESIGN
   ============================================ */
.pagination-area {
    margin-top: 70px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 0;
    position: relative;
}

.pagination-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #ba9269, transparent);
    border-radius: 2px;
}

.pagination-area .pagination {
    gap: 12px;
    margin: 0;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-area .page-item {
    margin: 0;
}

.pagination-area .page-link {
    border-radius: 12px;
    border: 2px solid #e9ecef;
    color: #495057;
    padding: 14px 20px;
    min-width: 48px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 700;
    font-size: 15px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 
        0 3px 10px rgba(0, 0, 0, 0.08),
        0 1px 3px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-area .page-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.6s ease;
}

.pagination-area .page-link:hover::before {
    left: 100%;
}

.pagination-area .page-link::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(186, 146, 105, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
    z-index: -1;
}

.pagination-area .page-link:hover::after {
    width: 300px;
    height: 300px;
}

.pagination-area .page-link:hover {
    background: linear-gradient(135deg, #ba9269 0%, #9a7a4f 100%);
    color: #ffffff;
    border-color: #ba9269;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 
        0 8px 25px rgba(186, 146, 105, 0.35),
        0 4px 12px rgba(186, 146, 105, 0.25);
    z-index: 1;
}

.pagination-area .page-item.active .page-link {
    background: linear-gradient(135deg, #ba9269 0%, #9a7a4f 100%);
    border-color: #ba9269;
    color: #ffffff;
    box-shadow: 
        0 8px 25px rgba(186, 146, 105, 0.4),
        0 4px 12px rgba(186, 146, 105, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    transform: translateY(-4px) scale(1.08);
    position: relative;
    z-index: 2;
}

.pagination-area .page-item.active .page-link::before {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
}

.pagination-area .page-item.active .page-link::after {
    background: rgba(255, 255, 255, 0.15);
    width: 300px;
    height: 300px;
}

.pagination-area .page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f8f9fa;
    color: #adb5bd;
}

.pagination-area .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    background: #f8f9fa;
    color: #adb5bd;
    border-color: #e9ecef;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .gallery-filter-wrapper {
        margin: 40px 0 50px;
    }
    
    .filter-header-text {
        margin-bottom: 30px;
        padding-bottom: 15px;
    }
    
    .filter-header-text::after {
        width: 60px;
        height: 3px;
    }
    
    .filter-header-text h3 {
        font-size: 22px;
    }
    
    .filter-header-text h3 i {
        font-size: 24px;
    }
    
    .filter-buttons-container {
        gap: 15px;
        padding: 25px 20px;
    }
    
    .filter-btn {
        padding: 14px 26px;
        font-size: 14px;
        gap: 10px;
    }
    
    .filter-btn i {
        font-size: 16px;
    }
    
    .gallery-image-container {
        height: 250px;
    }
    
    .gallery-card-body {
        padding: 20px;
    }
    
    .gallery-item-title {
        font-size: 17px;
    }
    
    .gallery-item-desc {
        font-size: 13px;
    }
    
    .gallery-action-btn {
        width: 50px;
        height: 50px;
        font-size: 16px;
    }
    
    .pagination-area {
        margin-top: 55px;
        padding: 25px 0;
    }
    
    .pagination-area::before {
        width: 180px;
    }
    
    .pagination-area .pagination {
        gap: 10px;
    }
    
    .pagination-area .page-link {
        padding: 13px 18px;
        min-width: 46px;
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .gallery-filter-wrapper {
        margin: 30px 0 40px;
    }
    
    .filter-header-text {
        margin-bottom: 25px;
        padding-bottom: 12px;
    }
    
    .filter-header-text::after {
        width: 50px;
        height: 3px;
    }
    
    .filter-header-text h3 {
        font-size: 20px;
        flex-direction: column;
        gap: 10px;
    }
    
    .filter-header-text h3 i {
        font-size: 22px;
    }
    
    .filter-buttons-container {
        gap: 12px;
        padding: 20px 15px;
        border-radius: 20px;
    }
    
    .filter-btn {
        padding: 12px 22px;
        font-size: 13px;
        gap: 8px;
    }
    
    .filter-btn i {
        font-size: 15px;
    }
    
    .gallery-image-container {
        height: 220px;
    }
    
    .gallery-card-body {
        padding: 18px;
    }
    
    .gallery-item-title {
        font-size: 16px;
    }
    
    .gallery-item-desc {
        font-size: 12px;
    }
    
    .gallery-action-btn {
        width: 45px;
        height: 45px;
        font-size: 15px;
    }
    
    .gallery-category-tag {
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        font-size: 11px;
    }
    
    .empty-gallery-state {
        padding: 60px 20px;
    }
    
    .empty-gallery-icon {
        font-size: 70px;
    }
    
    .empty-gallery-state h3 {
        font-size: 22px;
    }
    
    .pagination-area {
        margin-top: 50px;
        padding: 25px 0;
    }
    
    .pagination-area::before {
        width: 150px;
    }
    
    .pagination-area .pagination {
        gap: 8px;
    }
    
    .pagination-area .page-link {
        padding: 12px 16px;
        min-width: 44px;
        font-size: 14px;
    }
    
    .pagination-area .page-link:hover {
        transform: translateY(-3px) scale(1.03);
    }
    
    .pagination-area .page-item.active .page-link {
        transform: translateY(-3px) scale(1.05);
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