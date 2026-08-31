@extends('layouts.front')
@section('content')
<div class="container my-5 py-5">
    <h3 class="text=center py-3">Shopping Carts</h3>
    <div class="table-responsive">
        <table class="table table-border">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Item image</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>
    </div>
    <div>
        @guest
            <a href="/login" class="btn btn-primary">Login</a>
            @else
            <form action="" id="paymentForm" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="payment_slip" class="mb-1">Payment Slip Photo</label>
                    <input type="file" name="payment_slip" id="payment_slip" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="payment_method" class="mt-3">Payment_Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">Choose Payment Method</option>

                    </select>
                </div>
            </form>
            @endif
    </div>
</div>
@endsection
