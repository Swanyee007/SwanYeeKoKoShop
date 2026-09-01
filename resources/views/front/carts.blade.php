@extends('layouts.front')
@section('content')
<div class="container my-5 py-5">
    <h3 class="text-center py-3">Shopping Carts</h3>
    <div class="table-responsive">
        <table class="table table-border">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Item Name</th>
                    <th>Item Image</th>
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
    <div class="d-grid gap-2">
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
                <label for="payment_method" class="mt-3">Payemnt Method</label>
                <select name="payment_method" id="payment_method" class="form-select">
                    <option value="">Choose payment method</option>
                    @foreach($payments as $payment)
                        <option value="{{$payment->id}}">{{$payment->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="address">Customer Address</label>
                <input type="text" name="note" class="form-control" require>
            </div>
            <button class="btn btn-primary my-3" id="order-now" type="buttton">Order Now</button>
        </form>
        @endif
    </div>
</div>
@endsection
@section('script')
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('#order-now').click(function(){
            let itemString=localStorage.getItem('shops');
            $.post("{{ route('orderNow') }}",
            {data:itemString},function(response){
                console.log(response);
            })
        })
})
  </script>
@endsection
