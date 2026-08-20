@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Create Item</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.items.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Code No -->
        <div class="mb-3">
            <label class="form-label">Code No</label>
            <input type="text"
                name="code_no"
                value="{{old('code_no')}}"
                class="form-control @error ('code_no') is-invalid @enderror"
                placeholder="eg. 1234">
                @error('code_no')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror

        </div>

<!-- Item Name -->
<div class="mb-3">
    <label class="form-label">Item Name</label>
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
           name="image"
           class="form-control  @error ('image') is-invalid @enderror">
    @error('image')
            <div class="invalid-feedback">{{$message}}</div>
    @enderror
 </div>

<!-- Price -->
<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number"
           name="price"
           value="{{old('price')}}"
           class="form-control @error ('price') is-invalid @enderror">

        @error('price')
            <div class="invalid-feedback">{{$message}}</div>
        @enderror
</div>

<!-- Discount -->
<div class="mb-3">
    <label class="form-label">Discount (%)</label>
    <input type="number"
           name="discount"
           value="{{old('discount')}}"
           class="form-control @error ('discount') is-invalid @enderror">
           @error('discount')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
</div>

<!-- In Stock -->

 <select name="in_stock" value="{{old('in_stock')}}"
        class="form-select @error('in_stock') is-invalid @enderror">
    <option value="">InStock </option>
    <option value="1">Yes</option>
    <option value="0">No</option>

</select>

@error('in_stock')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
<!-- Description -->
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description"
              rows="4"
              class="form-control  @error ('description') is-invalid @enderror">{{old('description')}}</textarea>
    @error('description')
        <div class="invalid-feedback">{{$message}}</div>
    @enderror
    </div>

<!-- Category -->
<div class="mb-3">
    <label class="form-label">Category</label>

    <select name="category_id"
            class="form-select  @error ('category_id') is-invalid @enderror">

        <option value="">Choose Category</option>
        @foreach ($categories as $category)
            <option value="{{$category->id}}"
            {{old('category_id')== $category->id ? 'selected' : ''}}>
            {{$category->name}}</option>
        @endforeach

    </select>
    @error('category_id')
        <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>

                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Save Item
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
