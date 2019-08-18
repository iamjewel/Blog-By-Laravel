@extends('layouts.backend.backend-app')

@section('title','Tag')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">


        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header text-center">
                        <h2>
                            Edit Tag
                        </h2>
                    </div>

                    <div class="body">

                        <form action="{{route('admin.tag.update',$tag->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                           id="name" name="name" value="{{$tag->name}}">
                                    <label class="form-label">Tag Name</label>
                                </div>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>


                            <a class="btn btn-danger m-t-15 " href="{{route('admin.tag.index')}}">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 m-l-5 waves-effect">Update Tag</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('js')

@endpush
