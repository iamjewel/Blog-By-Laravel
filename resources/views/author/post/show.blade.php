@extends('layouts.backend.backend-app')

@section('title','Category')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">

        <a href="{{ route('author.post.index') }}" class="btn btn-danger waves-effect">BACK</a>

        @if($post->is_approved == false)

            <button type="button" class="btn btn-outline-primary waves-effect pull-right"
                    onclick="approvePost({{ $post->id }})">
                <i class="material-icons">clock</i>
                <span>Need Approval</span>
            </button>

            {{--            <form method="post" action="{{ route('admin.post.approve',$post->id) }}" id="approval-form" style="display: none">--}}
            {{--                @csrf--}}
            {{--                @method('PUT')--}}
            {{--            </form>--}}
        @else
            <button type="button" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
        @endif
        <br>
        <br>
        <br>


        <div class="row clearfix">

            {{--Post Details Part--}}
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header">
                        <h2>
                            {{ $post->title }}
                            <small>Posted By
                                <strong>
                                    <a href="">{{ $post->user->name }}</a>
                                </strong>
                                on {{ $post->created_at->toFormattedDateString() }}
                            </small>
                        </h2>
                    </div>

                    <div class="body">
                        {!! $post->body !!}
                    </div>
                </div>
            </div>

            {{--Rest Part--}}
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                <div class="card">
                    <div class="header bg-cyan">
                        <h2>
                            Categories
                        </h2>
                    </div>

                    <div class="body">
                        @foreach($post->categories as $category)
                            <span class="label bg-cyan">{{ $category->name }}</span>
                        @endforeach
                    </div>

                </div>

                <div class="card">
                    <div class="header bg-green">
                        <h2>
                            Tags
                        </h2>
                    </div>

                    <div class="body">
                        @foreach($post->tags as $tag)
                            <span class="label bg-green">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                </div>

                <div class="card">
                    <div class="header bg-amber">
                        <h2>
                            Featured Image
                        </h2>
                    </div>

                    <div class="body">
                        {{--                        <img class="img-responsive thumbnail" src="{{ url('storage/post/'. $post->image) }}">--}}
                        <img class="img-responsive thumbnail"
                             src="{{ Storage::disk('public')->url('post/'.$post->image) }}" alt="">
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection


@push('js')

@endpush
