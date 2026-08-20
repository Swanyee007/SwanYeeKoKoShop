@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
                        <h1 class="mt-4">Item</h1>
                        <a href="{{route('backend.items.create')}}" class="btn btn-primary float-end">Create Item</a>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Items</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Item Lists
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Code No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Instock</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Code No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Instock</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$item->code_no}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{{$item->in_stock}}</td>
                                                <td>{{$item->category_id}}</td>
                                                <td>
                                                    <a href="" class="btn btn-sn btn-primary">Edit</a>
                                                    <button class="btn btn-sn btn-danger delete" data-id="{{$item->id}}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$items->links()}}
                            </div>
                        </div>
                    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('tbody').on('click','.delete',function(){
                let id=$(this).data('id');
                console.log(id);
            })
        })
    </script>
@endsection
