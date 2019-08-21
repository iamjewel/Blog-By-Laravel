@extends('layouts.backend.backend-app')

@section('title','Category')

@push('css')

@endpush

@section('content')
    <div class="card">

        <div class="header">
            <div class="header row">

                <h2 class="col-md-6">
                    Manage Post
                    <span class="badge bg-info">{{$posts->count()}}</span>
                </h2>

                <a class="btn btn-primary waves-effect col-md-6" href="{{route('admin.post.create')}}">
                    <i class="material-icons">add</i>
                    <span>Add New Post</span>
                </a>
            </div>
        </div>

        <div class="body">
            <div class="table-responsive">


                <div>
                    <label>
                        Search:
                        <input type="search" placeholder="">
                    </label>

                </div>

                <table class=" table table-bordered table-striped table-hover text-center">

                    <thead>
                    <tr>

                        <th class="text-center">ID</th>
                        <th class="text-center">Author</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">View</th>
                        <th class="text-center">Approval</th>
                        <th class="text-center">Status</th>
                        {{--                        <th class="text-center">Body</th>--}}
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    @php($i=1)
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$post->user->name}}</td>
                            <td>{{str_limit($post->title,20)}}</td>
                            <td>{{$post->view_count}}</td>

                            <td>
                                @if($post->is_approved == true)
                                    <span class="badge bg-green">Approved</span>
                                @else
                                    <span class="badge bg-pink">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if($post->status == true)
                                    <span class="badge bg-green">Published</span>
                                @else
                                    <span class="badge bg-red">Not Published</span>
                                @endif
                            </td>
                            {{--                            <td>{{str_limit($post->body,20)}}</td>--}}
                            <td>{{$post->created_at->toFormattedDateString()}}</td>
                            <td>{{$post->updated_at->toFormattedDateString()}}</td>

                            <td class="text-center">
                                <a href="{{route('admin.post.show',$post->id)}}"
                                   class="btn btn-info waves-effect" >
                                    <i class="material-icons" >visibility</i>
                                </a>

                                <a href="{{route('admin.post.edit',$post->id)}}"
                                   class="btn btn-info waves-effect">
                                    <i class="material-icons">edit</i>
                                </a>

                                <button class="btn btn-danger waves-effect" type="button"
                                        onclick="deletePost({{$post->id}})">
                                    <i class="material-icons">delete</i>
                                </button>

                                <form id="delete-form-{{$post->id}}"
                                      action="{{route('admin.post.destroy',$post->id)}}"
                                      method="POST" style="display: none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>

                <div style="margin-left: 430px">
                    {{ $posts->links() }}
                </div>

                <div style="margin-left: 430px">

                </div>

            </div>
        </div>
    </div>
@endsection


@push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.15.3/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        function deletePost(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            })
        }
    </script>
@endpush
