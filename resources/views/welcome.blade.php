@extends('layouts.frontend.frontend-app')

@section('title','Welcome')

@push('css')
    <link href="{{asset('/')}}assets/frontend/css/home/styles.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/frontend/css/home/responsive.css" rel="stylesheet">

    <style>
        .favorite_posts {
            color: #870500;
        }
    </style>
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

                                {{--Category Imgae--}}
                                <div class="blog-image"><img
                                        src="{{Storage::disk('public')->url('post/'.$post->image)}}"
                                        alt="{{$post->title}}"></div>

                                {{--User Imgae--}}
                                <a class="avatar" href="#"><img
                                        src="{{Storage::disk('public')->url('profile/'.$post->user->image)}}"
                                        alt="Profile Image"></a>

                                <div class="blog-info">

                                    {{--Title--}}
                                    <h4 class="title">
                                        <a href="{{ route('post.details',$post->slug) }}">
                                            <b>{{$post->title}}</b>
                                        </a>
                                    </h4>

                                    {{--Footer--}}
                                    <ul class="post-footer">
                                        <li>
                                            @guest()
                                                <a href="javascript:void(0);"
                                                   onclick="toastr.info('To Add Favorite Post Plz Login','info',{closeButton:true,progressBar:true})">
                                                    <i class="ion-heart"></i>
                                                    {{$post->favorite_to_users->count()}}
                                                </a>

                                            @else
                                                <a href="javascript:void(0);"
                                                   onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                                   class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}">
                                                    <i class="ion-heart"></i>
                                                    {{$post->favorite_to_users->count()}}

                                                    <form id="favorite-form-{{$post->id}}" method="POST"
                                                          action="{{route('post.favorite',$post->id)}}"
                                                          style="display: none">
                                                        @csrf
                                                    </form>
                                                </a>
                                            @endguest
                                        </li>

                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>

                                        <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col-lg-4 col-md-6 -->
                @endforeach

            </div>

            <div style="margin-left: 430px">
                {{ $posts->links() }}
            </div>

            <div style="margin-left: 430px">

            </div>

        </div>
    </section>
@endsection

@push('js')

@endpush
