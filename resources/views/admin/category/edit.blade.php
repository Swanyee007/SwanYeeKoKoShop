@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Edit Category</h4>
            <a href="{{route('backend.categories.index')}}" class="btn btn-danger">Cancel</a>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')



<!-- Item Name -->
<div class="mb-3">
    <label class="form-label">Category Name</label>
    <input type="text"
           name="name"
           value="{{old('name',$category->name)}}"
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
            <img src="{{asset($category->image)}}" class="w-25 h-25 my-2" alt="">
            <input type="hidden" name="old_image" id="" value="{{$category->image}}">
          </div>
          <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
             <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{old('image')}}">
          </div>
        </div>
      </div>




                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update Category
                    </button>

                    <a href="{{ route('backend.categories.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
