@extends('layouts.frontend.frontend-app')

@section('title','Welcome')

@push('css')
    <link href="{{asset('/')}}assets/frontend/css/home/styles.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/frontend/css/home/responsive.css" rel="stylesheet">
@endpush


@section('content')
    <div class="main-slider">
        <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
             data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
             data-swiper-breakpoints="true" data-swiper-loop="true">

            <!-- swiper-container -->
            <div class="swiper-wrapper">

            @foreach($categories as $category)
                <!-- swiper-slide-Start -->
                    <div class="swiper-slide">
                        <a class="slider-category" href="#">
                            <div class="blog-image"><img
                                    src="{{Storage::disk('public')->url('category/slider/'.$category->image)}}"
                                    alt="{{$category->name}}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{$category->name}}</b></h3>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                    <!-- swiper-slide -->
                @endforeach

            </div>
            <!-- swiper-container -->

        </div>
    </div>

    <section class="blog-area section">
        <div class="container">
            <div class="row">

            @foreach($posts as $post)
                <!-- col-lg-4 col-md-6 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img
                                        src="{{Storage::disk('public')->url('post/'.$post->image)}}"
                                        alt="{{$post->title}}"></div>

                                <a class="avatar" href="#"><img
                                        src="{{asset('/')}}assets/frontend/images/icons8-team-355979.jpg"
                                        alt="Profile Image"></a>

                                <div class="blog-info">

                                    {{--Title--}}
                                    <h4 class="title">
                                        <a href="#">
                                            <b>{{$post->title}}</b>
                                        </a>
                                    </h4>

                                    {{--Footer--}}
                                    <ul class="post-footer">
                                        <li><a href="#"><i class="ion-heart"></i>57</a></li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>138</a></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col-lg-4 col-md-6 -->
                @endforeach

            </div>

            <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

        </div>
    </section>
@endsection

@push('js')

@endpush
