@extends('layouts.backend.backend-app')

@section('title','Post')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{asset('/')}}assets/backend/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet"/>

@endpush

@section('content')
    <div class="container-fluid">

        <form action="{{route('admin.post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!--Add Post Title-->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="header text-center">
                            <h2>
                                Add New Post
                            </h2>
                        </div>

                        <div class="body">

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                           id="title" name="title">
                                    <label class="form-label">Post Title</label>
                                </div>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <span>Image</span>
                                <div class="form-line">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                           id="image" name="image">

                                </div>

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <p style="color: red">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="filled-in" type="checkbox" id="status" name="status" value="1">
                                <label for="status">Publish</label>
                            </div>

                        </div>
                    </div>
                </div>

                <!--Category an Tag Part-->
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="header text-center">
                            <h2>
                                Select Categories & Tags
                            </h2>
                        </div>

                        <div class="body">

                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('categories') ? 'focused error' : '' }}">
                                    <label for="category">Select Category</label>
                                    <select name="categories[]" id="category" class="form-control show-tick"
                                            data-live-search="true" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('tags') ? 'focused error' : '' }}">
                                    <label for="tag">Select Tags</label>
                                    <select name="tags[]" id="tag" class="form-control show-tick"
                                            data-live-search="true" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>


                        </div>
                    </div>
                </div>
            </div>


            <!--Add Post Body-->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="header text-center">
                            <h2>
                                Post Details!
                            </h2>
                        </div>

                        <div class="body">
                            <textarea class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
@endsection


@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('/')}}assets/backend/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <script>
        $(function () {

            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('/')}}assets/backend//plugins/tinymce';
        });
    </script>
@endpush
