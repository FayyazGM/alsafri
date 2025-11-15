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
            @forelse($projects as $project)
            <div class="col-xl-4 col-md-6">
                <div class="projects-boxes-area">
                    <div class="img1">
                            <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}">
                    </div>
                    <div class="contain-main-area">
                    <div class="content-p-area">
                                <span>{{ $project->category }}</span>
                    <div class="space12"></div>
                                <a href="{{ route('project-detail', $project->slug) }}" class="title">{{ $project->title }}</a>
                    </div>
                    <div class="arrow">
                                <a href="{{ route('project-detail', $project->slug) }}"><i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                    </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No projects available at the moment.</p>
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
</div>
<!--===== PROJECTS AREA ENDS =======-->

@endsection