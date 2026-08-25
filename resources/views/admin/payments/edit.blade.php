@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Edit Payment</h4>
            <a href="{{route('backend.payments.index')}}" class="btn btn-danger">Cancel</a>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.payments.update',$payment->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')



<!-- Item Name -->
<div class="mb-3">
    <label class="form-label">Payment Name</label>
    <input type="text"
           name="name"
           value="{{old('name',$payment->name)}}"
           class="form-control  @error ('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror

   </div>

 <!-- Image -->

      <div class="mb-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Image</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="new_image-tab" data-bs-toggle="tab" data-bs-target="#new_image-tab-pane" type="button" role="tab" aria-controls="new_image-tab-pane" aria-selected="false">New Image</button>
          </li>

        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
            <img src="{{asset($payment->logo)}}" class="w-25 h-25 my-2" alt="">
            <input type="hidden" name="old_image" id="" value="{{$payment->logo}}">
          </div>
          <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
             <input type="file" accept="image/*" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" value="{{old('logo')}}">
          </div>
        </div>
      </div>




                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update Payment
                    </button>

                    <a href="{{ route('backend.items.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
