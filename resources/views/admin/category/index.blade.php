@extends('layouts.backend.backend-app')

@section('title','Category')

@push('css')

@endpush

@section('content')
    <div class="card">

        <div class="header">
            <div class="header row">

                <h2 class="col-md-6">
                    Manage Category
                </h2>

                <a class="btn btn-primary waves-effect col-md-6" href="{{route('admin.category.create')}}">
                    <i class="material-icons">add</i>
                    <span>Add New Category</span>
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
                        <th class="text-center">Name</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    @php($i=1)
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->created_at}}</td>
                            <td>{{$category->updated_at}}</td>

                            <td class="text-center">
                                <a href="{{route('admin.category.edit',$category->id)}}"
                                   class="btn btn-info waves-effect">
                                    <i class="material-icons">edit</i>
                                </a>

                                <button class="btn btn-danger waves-effect" type="button"
                                        onclick="deleteCategory({{$category->id}})">
                                    <i class="material-icons">delete</i>
                                </button>

                                <form id="delete-form-{{$category->id}}"
                                      action="{{route('admin.category.destroy',$category->id)}}"
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
                    {{ $categories->links() }}
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
        function deleteCategory(id) {
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
