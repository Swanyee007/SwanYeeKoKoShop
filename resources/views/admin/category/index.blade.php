@extends('layouts.admin')

@section('content')

@if(session('success'))

    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>

@endif


<div class="container-fluid px-4">

    <h1 class="mt-4">Category</h1>

    <a href="{{ route('backend.categories.create') }}"
       class="btn btn-primary float-end">

        Create Category

    </a>


    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item">

            <a href="{{ route('backend.dashboard') }}">
                Dashboard
            </a>

        </li>

        <li class="breadcrumb-item active">
            Category
        </li>

    </ol>


    <div class="card mb-4">

        <div class="card-header">

            <i class="fas fa-table me-1"></i>

            Category Lists

        </div>


        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>No.</th>

                        <th>Name</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tfoot>

                    <tr>

                        <th>No.</th>

                        <th>Name</th>

                        <th>Action</th>

                    </tr>

                </tfoot>


                <tbody>

                    @php
                        $i = 1;
                    @endphp


                    @foreach($categories as $category)

                        {{-- Parent Category --}}
                        <tr>

                            <td>
                                {{ $i++ }}
                            </td>


                            <td>

                                <strong>

                                    <i class="fas fa-folder text-warning me-2"></i>

                                    {{ $category->name }}

                                </strong>

                            </td>


                            <td>

                                <a href="{{ route('backend.categories.edit', $category->id) }}"
                                   class="btn btn-sn btn-primary">

                                    Edit

                                </a>


                                <button class="btn btn-sn btn-danger delete"
                                        data-id="{{ $category->id }}">

                                    Delete

                                </button>

                            </td>

                        </tr>


                        {{-- Child Categories --}}
                        @foreach($category->children as $child)

                            <tr>

                                <td>
                                    {{ $i++ }}
                                </td>


                                <td>

                                    <span style="padding-left: 30px;">

                                        <i class="fas fa-level-up-alt fa-rotate-90 text-muted me-2"></i>

                                        <i class="fas fa-folder-open text-info me-2"></i>

                                        {{ $child->name }}

                                    </span>

                                </td>


                                <td>

                                    <a href="{{ route('backend.categories.edit', $child->id) }}"
                                       class="btn btn-sn btn-primary">

                                        Edit

                                    </a>


                                    <button class="btn btn-sn btn-danger delete"
                                            data-id="{{ $child->id }}">

                                        Delete

                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    @endforeach

                </tbody>

            </table>


            {{ $categories->links() }}

        </div>

    </div>

</div>



<!-- Modal -->

<div class="modal fade"
     id="deleteModal"
     tabindex="-1"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-danger text-light">

                <h1 class="modal-title fs-5" id="exampleModalLabel">

                    Delete Category

                </h1>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">

                </button>

            </div>


            <div class="modal-body">

                Are you sure you want to Delete?

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    No

                </button>


                <form action=""
                      id="deleteForm"
                      method="POST">

                    @csrf

                    @method('delete')


                    <button type="Submit"
                            class="btn btn-primary">

                        Yes

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

    setTimeout(function(){

        $('#success-alert').fadeOut();

    }, 3000);

</script>

@endsection



@section('script')

<script>

    $(document).ready(function(){

        $('tbody').on('click', '.delete', function(){

            let id = $(this).data('id');

            // Original delete action
            $('#deleteForm').attr('action', `categories/${id}`);

            // Show original modal
            $('#deleteModal').modal('show');

        });

    });

</script>

@endsection
