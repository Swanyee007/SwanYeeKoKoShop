@extends('layouts.admin')
@section('content')
@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{session('success')}}
    </div>
@endif
     <div class="container-fluid px-4">
                        <div class="my-3">
                            <h1 class="mt-4 d-inline">
                                @if(Request::is('backend/orderAccept'))
                                    Order Accept
                                @elseif(Request::is('backend/orderComplete'))
                                    Order Complete
                                @else
                                    Order Lists
                                @endif
                            </h1>
                            <a href="{{route('backend.ordercomplete')}}" class="btn btn-success float-end">Order Complete</a>
                            <a href="{{route('backend.orderAccept')}}" class="btn btn-primary float-end">Order Accept</a>
                            <a href="{{route('backend.orders')}}" class="btn btn-secondary float-end">Order List</a>
                        </div>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Order Lists
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Voucher No</th>
                                            <th>User Name</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                         <tr>
                                            <th>No.</th>
                                            <th>Voucher No</th>
                                            <th>User Name</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                   <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach ($order_data as $order)

                                            @if($order !=null)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$order->voucher_no}}</td>
                                                <td>{{$order->user->name}}</td>
                                                <td>
                                                    <span class="badge
                                                    @if($order->status=='Pending')
                                                    {{'text-bg-secondary'}}
                                                    @elseif($order->status=='Accept')
                                                    {{'text-bg-primary'}}
                                                    @else
                                                    {{'text-bg-secondary'}}
                                                    @endif">{{$order->status}}</span>
                                                </td>
                                                <td>
                                                    {{$order->payment->name}}
                                                </td>
                                                <td>
                                                    <a href="">Details</a>
                                                </td>
                                            </tr>

                                            @endif

                                        @endforeach
                                   </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

            </div>

@endsection
