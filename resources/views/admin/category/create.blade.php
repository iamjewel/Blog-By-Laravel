@extends('layouts.backend.backend-app')

@section('title','Category')

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
                            Add New Category
                        </h2>
                    </div>

                    <div class="body">

                        <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                           id="name"  name="name">
                                    <label class="form-label">Category Name</label>
                                </div>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                           id="image"  name="image">
                                    <label class="form-label">Image</label>
                                </div>

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>


                            <a class="btn btn-danger m-t-15 " href="{{route('admin.category.index')}}">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 m-l-5 waves-effect">Save Category</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('js')

@endpush
