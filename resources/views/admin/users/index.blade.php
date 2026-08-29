@extends('layouts.admin')
@section('content')
@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{session('success')}}
    </div>
@endif
     <div class="container-fluid px-4">
                        <h1 class="mt-4">User</h1>
                        <a href="{{route('backend.users.create')}}"
                        class="btn btn-primary float-end">Create User</a>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                User Lists
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                         <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                   <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->password}}</td>
                                            <td>{{$user->role}}</td>
                                            <td>
                                                <a href="{{route('backend.users.edit',$user->id)}}" class="btn btn-sn btn-primary">Edit</a>
                                                <button class="btn btn-sn btn-danger delete" data-id="{{$user->id}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                   </tbody>
                                </table>
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Delete User Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form action="" id="deleteForm" method="POST">
                        @csrf
                        @method('delete')
                        <button type="Submit" class="btn btn-primary">Yes</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <script>
                 setTimeout(function(){
                    $('#success-alert').fadeOut();
                 },3000);
            </script>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('tbody').on('click','.delete',function(){
                let id=$(this).data('id');
                //console.log(id);
                $('#deleteForm').attr('action',`users/${id}`);
                $('#deleteModal').modal('show');
            })
        })
    </script>
@endsection
