@extends('public.layout')
@section('title', 'Project Details - Alsafri - السفري')
@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="all-inner-header-area" style="background-image: url({{ asset('assets/img/all-images/bg/hero-bg4.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row align-items-center p-5">
            <div class="col-xl-8 col-lg-8">
                <div class="heading1">
                    <h1>{{ $project->title }}</h1>
                    <div class="space16"></div>
                    <a href="{{ route('home') }}">Home <i class="fa-solid fa-angle-right"></i> <a href="{{ route('projects') }}">Projects <i class="fa-solid fa-angle-right"></i> <span>{{ $project->title }}</span></a>
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
<div class="project-main-details-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 m-auto">
                <div class="project-main-widget-area heading1">
                    <div class="img1">
                        <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}">
                    </div>
                    <div class="space32"></div>
                    <h3>{{ $project->title }}</h3>
                    <div class="space16"></div>
                    <p>{{ $project->description }}</p>
                    
                    @if($project->additional_content)
                        <div class="space16"></div>
                        <p>{{ $project->additional_content }}</p>
                    @endif

                    @if($project->features)
                        <div class="space32"></div>
                        <h3>Project Features</h3>
                        <div class="space16"></div>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-6">
                                <div class="img1">
                                    <img src="{{ $project->secondary_image_url ?: asset('assets/img/all-images/service/s-img15.png') }}" alt="{{ $project->title }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="space32 d-lg-none d-block"></div>
                                <div class="details">
                                    <ul>
                                        @foreach($project->features as $feature)
                                            <li><img src="{{ asset('assets/img/icons/check1.svg') }}" alt=""> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($project->progress_data)
                        <div class="space32"></div>
                        <h3>Project Progress</h3>
                        <div class="space16"></div>
                        <div class="progress-bar-container">
                            @foreach($project->progress_data as $progress)
                                <div class="progress-item" data-aos="fade-left" data-aos-duration="1000">
                                    <div class="label">
                                        <span>{{ $progress['label'] }}</span>
                                        <span>{{ $progress['percentage'] }}%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="bar red" style="width: {{ $progress['percentage'] }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($project->conclusion)
                        <div class="space32"></div>
                        <div class="pera">
                            <p>{{ $project->conclusion }}</p>
                        </div>
                    @endif

                    @if($project->gallery_images && count($project->gallery_images) > 0)
                        <div class="space32"></div>
                        <h3>Project Gallery</h3>
                        <div class="space16"></div>
                        <div class="row">
                            @foreach($project->gallery_images as $image)
                                @php
                                    $imageUrl = $image['url'] ?? '';
                                    if ($imageUrl) {
                                        $imageUrl = Str::startsWith($imageUrl, ['http://', 'https://']) ? $imageUrl : Storage::url($imageUrl);
                                    }
                                @endphp
                                @if(!empty($imageUrl))
                                    <div class="col-xl-4 col-md-6 mb-3">
                                        <div class="project-gallery-item">
                                            <img src="{{ $imageUrl }}" alt="{{ $image['alt'] ?? $project->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Projects Section -->
<div class="project-inner-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="heading1 text-center space-margin60">
                    <h2>Related Projects</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($relatedProjects as $relatedProject)
                <div class="col-xl-4 col-md-6">
                    <div class="projects-boxes-area">
                        <div class="img1">
                            <img src="{{ $relatedProject->featured_image_url }}" alt="{{ $relatedProject->title }}">
                        </div>
                        <div class="contain-main-area">
                            <div class="content-p-area">
                                <span>{{ $relatedProject->category }}</span>
                                <div class="space12"></div>
                                <a href="{{ route('project-detail', $relatedProject->slug) }}" class="title">{{ $relatedProject->title }}</a>
                            </div>
                            <div class="arrow">
                                <a href="{{ route('project-detail', $relatedProject->slug) }}"><i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No related projects found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!--===== PROJECTS AREA ENDS =======-->
@endsection

@section('custom-css')
<style>
/* Project Detail Page Styles */
.project-gallery-item {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.project-gallery-item:hover {
    transform: translateY(-5px);
}

.project-gallery-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.progress-bar-container {
    margin-top: 20px;
}

.progress-item {
    margin-bottom: 20px;
}

.progress-item .label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-weight: 600;
}

.progress {
    height: 8px;
    background-color: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress .bar {
    height: 100%;
    background: linear-gradient(90deg, #007bff, #0056b3);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.details ul {
    list-style: none;
    padding: 0;
}

.details ul li {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    font-size: 16px;
}

.details ul li img {
    margin-right: 12px;
    width: 20px;
    height: 20px;
}
</style>
@endsection
