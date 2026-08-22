@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Edit Item</h4>
            <a href="{{route('backend.items.index')}}" class="btn btn-danger">Cancel</a>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.items.update',$item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Code No -->
        <div class="mb-3">
            <label class="form-label">Code No</label>
            <input type="text"
                name="code_no"
                value="{{old('code_no',$item->code_no)}}"
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
           value="{{old('name',$item->name)}}"
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
            <img src="{{asset($item->image)}}" class="w-25 h-25 my-2" alt="">
            <input type="hidden" name="old_image" id="" value="{{$item->image}}">
          </div>
          <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
             <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{old('image')}}">
          </div>
        </div>
      </div>


<!-- Price -->
<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number"
           name="price"
           value="{{old('price',$item->price)}}"
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
           value="{{old('discount',$item->discount)}}"
           class="form-control @error ('discount') is-invalid @enderror">
           @error('discount')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
</div>

<!-- In Stock -->

 <select name="in_stock" value="{{old('in_stock')}}"
        class="form-select @error('in_stock') is-invalid @enderror" >
    <option value="">InStock </option>
    <option value="1" {{$item->in_stock==1 ? 'selected':''}}>Yes</option>
    <option value="0" {{$item->in_stock==0 ? 'selected':''}}>No</option>

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
              class="form-control  @error ('description') is-invalid @enderror">{{old('description',$item->description)}}</textarea>
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
            {{old('category_id',$item->category_id)== $category->id ? 'selected' : ''}}>
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
                        Update Item
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
