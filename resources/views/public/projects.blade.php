@extends('public.layout')
@section('title', 'Projects - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center p-5">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>Our Major Projects</h1>
                    <div class="space16"></div>
                    <a href="{{ route('home') }}">Home <i class="fa-solid fa-angle-right"></i> <span>Projects</span></a>
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

<!--===== PROJECTS AREA STARTS =======-->
<div class="project-inner-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5 class="vl-section-subtitle" data-aos="zoom-in-up" data-aos-duration="900"><img src="{{ asset('assets/img/elements/elements5.png') }}" alt=""> <span>PROJECTS</span> <img src="{{ asset('assets/img/elements/elements6.png') }}" alt=""></h5>
                    <div class="space16"></div>
                    <h2 class="vl-section-title" data-aos="zoom-in-up" data-aos-duration="1000">Our Major Steel Fabrication Projects</h2>
                    <div class="space16"></div>
                    <p data-aos="zoom-in-up" data-aos-duration="1100">Discover our portfolio of completed projects including elevator cladding, escalator installations, steel structures, and custom fabrication work across Saudi Arabia.</p>
                </div>
            </div>
        </div>

        <div class="row projects-grid" id="projects-grid">
            @forelse($projects as $project)
                <div class="col-xl-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="project-card-modern">
                        <div class="project-image-container">
                            <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" class="project-img">
                            <div class="project-overlay-modern">
                                <div class="project-actions">
                                    <a href="{{ route('project-detail', $project->slug) }}" class="project-action-btn" title="View Project Details">
                                        <i class="fa-solid fa-eye"></i>
                                        <span>View Details</span>
                                    </a>
                                </div>
                            </div>
                            <div class="project-category-tag">
                                <i class="fa-solid fa-folder"></i>
                                <span>{{ ucfirst($project->category) }}</span>
                            </div>
                        </div>
                        <div class="project-card-body">
                            <h4 class="project-item-title">
                                <a href="{{ route('project-detail', $project->slug) }}">{{ $project->title }}</a>
                            </h4>
                            <div class="project-footer">
                                <a href="{{ route('project-detail', $project->slug) }}" class="project-link-btn">
                                    <span>Read More</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-projects-state" data-aos="fade-up" data-aos-duration="1000">
                        <div class="empty-projects-icon">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        <h3>No Projects Available</h3>
                        <p>We're currently updating our projects portfolio. Please check back soon!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="col-xl-12">
            <div class="space18"></div>
            <div class="pagination-area">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
<!--===== PROJECTS AREA ENDS =======-->
@endsection

@section('custom-css')
<style>
/* ============================================
   MODERN PROJECTS PAGE - COMPLETE REDESIGN
   ============================================ */

/* Modern Projects Cards - Premium Design */
.projects-grid {
    margin-top: 50px;
}

.project-card-modern {
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

.project-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(186, 146, 105, 0.2);
    border-color: #ba9269;
}

.project-image-container {
    position: relative;
    overflow: hidden;
    height: 280px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.project-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-card-modern:hover .project-img {
    transform: scale(1.12);
}

.project-overlay-modern {
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

.project-card-modern:hover .project-overlay-modern {
    opacity: 1;
}

.project-actions {
    display: flex;
    gap: 15px;
    align-items: center;
    justify-content: center;
}

.project-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 28px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    color: #ba9269;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 16px;
    font-weight: 700;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    transform: scale(0.8);
}

.project-card-modern:hover .project-action-btn {
    transform: scale(1);
}

.project-action-btn:hover {
    background: #ffffff;
    color: #9a7a4f;
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.project-action-btn i {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.project-action-btn:hover i {
    transform: translateX(5px);
}

.project-category-tag {
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

.project-category-tag i {
    font-size: 11px;
}

.project-card-modern:hover .project-category-tag {
    background: rgba(154, 122, 79, 0.95);
    transform: scale(1.05);
}

.project-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ffffff;
}

.project-item-title {
    margin: 0 0 20px 0;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
    color: #2c3e50;
    min-height: 56px;
}

.project-item-title a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.project-item-title a:hover {
    color: #ba9269;
}

.project-footer {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
}

.project-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #ba9269;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    padding: 8px 0;
}

.project-link-btn:hover {
    color: #9a7a4f;
    gap: 15px;
}

.project-link-btn i {
    transition: transform 0.3s ease;
    font-size: 14px;
}

.project-link-btn:hover i {
    transform: translateX(5px);
}

/* Empty State - Modern Design */
.empty-projects-state {
    text-align: center;
    padding: 100px 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 20px;
    margin: 50px 0;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.empty-projects-icon {
    font-size: 100px;
    color: #dee2e6;
    margin-bottom: 30px;
    opacity: 0.6;
}

.empty-projects-state h3 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
}

.empty-projects-state p {
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
    .projects-grid {
        margin-top: 40px;
    }
    
    .project-image-container {
        height: 250px;
    }
    
    .project-card-body {
        padding: 20px;
    }
    
    .project-item-title {
        font-size: 18px;
        min-height: 50px;
    }
    
    .project-action-btn {
        padding: 14px 24px;
        font-size: 15px;
    }
    
    .project-link-btn {
        font-size: 14px;
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
    .projects-grid {
        margin-top: 30px;
    }
    
    .project-image-container {
        height: 220px;
    }
    
    .project-card-body {
        padding: 18px;
    }
    
    .project-item-title {
        font-size: 17px;
        min-height: 48px;
        margin-bottom: 15px;
    }
    
    .project-action-btn {
        padding: 12px 20px;
        font-size: 14px;
        gap: 8px;
    }
    
    .project-action-btn i {
        font-size: 16px;
    }
    
    .project-category-tag {
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        font-size: 11px;
    }
    
    .project-link-btn {
        font-size: 13px;
    }
    
    .empty-projects-state {
        padding: 60px 20px;
    }
    
    .empty-projects-icon {
        font-size: 70px;
    }
    
    .empty-projects-state h3 {
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