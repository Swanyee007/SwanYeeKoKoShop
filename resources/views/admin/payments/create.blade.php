@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Create Payment</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.payments.store')}}" method="POST" enctype="multipart/form-data">
                @csrf


<!-- Item Name -->
<div class="mb-3">
    <label class="form-label">Payment Name</label>
    <input type="text"
           name="name"
           value="{{old('name')}}"
           class="form-control  @error ('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror

   </div>

<!-- Image -->
<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file"
           accept="image/*"
           name="logo"
           class="form-control  @error ('logo') is-invalid @enderror">
    @error('image')
            <div class="invalid-feedback">{{$message}}</div>
    @enderror
 </div>

                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Save Payment
                    </button>

                    <a href="{{ route('backend.payments.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
