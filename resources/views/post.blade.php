@extends('layouts.frontend.frontend-app')

@section('title')
    {{ $post->title }}
@endsection

@push('css')
    <link href="{{asset('/')}}assets/frontend/css/single-post/styles.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/frontend/css/single-post/responsive.css" rel="stylesheet">

    <style>
        .header-bg {
            height: 400px;
            width: 100%;
            background-image: url({{ Storage::disk('public')->url('post/'.$post->image) }});
            background-size: cover;
        }

        .favorite_posts {
            color: #870500;
        }
    </style>

@endpush

@section('content')

    <!-- Slider -->
    <div class="header-bg">

    </div>

    <section class="post-area section">
        <div class="container">

            <div class="row">


                <!-- Main-Post-Info -->
                <div class="col-lg-8 col-md-12 no-right-padding">

                    <!-- Main-Post -->
                    <div class="main-post">
                        <div class="blog-post-inner">

                            <!-- post-info -->
                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img
                                            src="{{ Storage::disk('public')->url('profile/'.$post->user->image) }}"
                                            alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{ $post->user->name }}</b></a>
                                    <h6 class="date"> on {{ $post->created_at->diffForHumans() }}</h6>
                                </div>

                            </div>

                            <!-- Title -->
                            <h3 class="title">
                                <a href="#">
                                    <b>{{ $post->title }}</b>
                                </a>
                            </h3>

                            <!-- Body -->
                            <div class="para">
                                {!! html_entity_decode($post->body) !!}
                            </div>

                            <!-- Tags -->
                            <ul class="tags">
                                @foreach($post->tags as $tag)
                                    <li><a href="{{route('tag.posts',$tag->slug)}}">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>

                        </div>

                        <div class="post-icons-area">

                            <ul class="post-icons">

                                <!-- Favorite -->
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

                                <!-- Comment -->
                                <li><a href=""><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>

                                <!-- View Count -->
                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE :</li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>

                    </div>

                </div>

                <!-- Main-Post-Sidebar -->
                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <!-- About-Author -->
                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT Author</b></h4>
                            <p>{{$post->user->about}}</p>
                        </div>


                        <!-- Tags-->
                        <div class="tag-area">
                            <h4 class="title"><b>CATEGORIES</b></h4>
                            <ul>
                                @foreach($post->categories as $category)
                                    <li><a href="{{route('category.posts',$category->slug)}}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- Random-Post -->
    <section class="recomended-area section">
        <div class="container">
            <div class="row">
                @foreach($randomposts as $randompost)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img
                                        src="{{ Storage::disk('public')->url('post/'.$randompost->image) }}"
                                        alt="{{ $randompost->title }}"></div>

                                <a class="avatar" href=""><img
                                        src="{{ Storage::disk('public')->url('profile/'.$randompost->user->image) }}"
                                        alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a
                                            href="{{ route('post.details',$randompost->slug) }}"><b>{{ $randompost->title }}</b></a>
                                    </h4>

                                    <ul class="post-footer">

                                        <!-- Favorite -->
                                        <li>
                                            @guest()
                                                <a href="javascript:void(0);"
                                                   onclick="toastr.info('To Add Favorite Post Plz Login','info',{closeButton:true,progressBar:true})">
                                                    <i class="ion-heart"></i>
                                                    {{$post->favorite_to_users->count()}}
                                                </a>

                                            @else
                                                <a href="javascript:void(0);"
                                                   onclick="document.getElementById('favorite-form-{{ $randompost->id }}').submit();"
                                                   class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$randompost->id)->count()  == 0 ? 'favorite_posts' : ''}}">
                                                    <i class="ion-heart"></i>
                                                    {{$randompost->favorite_to_users->count()}}

                                                    <form id="favorite-form-{{$randompost->id}}" method="POST"
                                                          action="{{route('post.favorite',$randompost->id)}}"
                                                          style="display: none">
                                                        @csrf
                                                    </form>
                                                </a>
                                            @endguest
                                        </li>

                                        <!-- Comment -->
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$randompost->comments->count()}}</a></li>

                                        <!-- View Count -->
                                        <li><a href="#"><i class="ion-eye"></i>{{$randompost->view_count}}</a></li>


                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div>
                @endforeach


            </div>

        </div>
    </section>


    <!-- Comments -->
    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">

                        @guest()
                            <p>For post a new comment. You need to login first. <a href="{{ route('login') }}">Login</a>
                            </p>
                        @else
                            <form method="post" action="{{route('comment.store',$post->id)}}">
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true"
                                              aria-invalid="false"></textarea>
                                    </div>

                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        @endguest
                    </div>

                    <h4><b>Total Comments ( {{$post->comments->count()}} ) </b></h4>


                    <!-- Comments Info -->

                    <div class="commnets-area ">
                        @if($post->comments->count() > 0)
                            @foreach($post->comments as $comment)
                                <div class="commnets-area ">

                                    <div class="comment">

                                        <div class="post-info">

                                            <div class="left-area">
                                                <a class="avatar" href="#"><img
                                                        src="{{ Storage::disk('public')->url('profile/'.$comment->user->image) }}"
                                                        alt="Profile Image"></a>
                                            </div>

                                            <div class="middle-area">
                                                <a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
                                                <h6 class="date">on {{ $comment->created_at->diffForHumans()}}</h6>
                                            </div>

                                        </div><!-- post-info -->

                                        <p>{{ $comment->comment }}</p>

                                    </div>

                                </div><!-- commnets-area -->
                            @endforeach
                        @else

                            <div class="commnets-area ">

                                <div class="comment">
                                    <p>No Comment yet. Be the first :)</p>
                                </div>
                            </div>

                        @endif
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection

@push('js')

@endpush
