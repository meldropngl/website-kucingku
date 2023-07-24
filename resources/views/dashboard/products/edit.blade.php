@extends('dashboard.layouts.main')

@section('container')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Products</h1>
  </div>

  <div class="col-lg-6">
  <form method="post" action="/dashboard/products/{{ $product['id'] }}" enctype="multipart/form-data">
  @method('put')
   @csrf
   <input type="hidden" name="oldImage" value="{{ $product['image'] }}">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product['name']) }}" required>
      @error('name')
        <div class="d-block invalid-feedback text-start">
            {{ $message }}
        </div>
      @enderror
    </div>

  <div class="mb-3">
    <label for="brand" class="form-label">Brand</label>
    <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $product['brand']) }}" required>
  </div>

   <div class="mb-3">
  <label for="type">Type</label>
	<select id="type" class="form-control" name="type" required style="cursor:pointer;">
						<option value="">Select Product Type</option>
			      <option value="Accessories" @if(old('type', $product['type']) == 'Accessories') selected @endif>Accessories</option>
					  <option value="Cage" @if(old('type', $product['type']) == 'Cage') selected @endif>Cage</option>
            <option value="Cat" @if(old('type', $product['type']) == 'Cat') selected @endif>Cat</option>
						<option value="Food" @if(old('type', $product['type']) == 'Food') selected @endif>Food</option>
            <option value="Shampoo" @if(old('type', $product['type']) == 'Shampoo') selected @endif>Shampoo</option>
		</select>
  </div>
  
 <div class="mb-3">
    <label for="price" class="form-label">Price</label>
   <input type="text" name="price" class="form-control" id="price" maxlength="16" value="@if(old('price')) {{ old('price') }} @else{{ 'Rp. ' . number_format($product['price'],0,'.','.'); }}@endif" required>
  </div>

    <div class="mb-3">
    <label for="qty" class="form-label">Quantity</label>
    <input type="number" class="form-control" id="qty" name="qty" min="1" value="1" value="{{ old('qty', $product['qty']) }}" required>
  </div>
        <div class="mb-3">
					<label for="image">Image</label>
						<img src="{{ asset('storage/'.$product['image']) }}" class="img-thumbnail mb-2" style="width:120px;display:block;" id=img-preview>
						<div class="custom-file">
             <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"  onchange="previewImage();" value="{{ old('image') }}">
					  <label class="custom-file-label">
    
      @error('image')
        <div class="d-block invalid-feedback text-start">
            {{ $message }}
        </div>
      @enderror
      </div>
 
     <div class="mb-3">
    <label for="desc">Description</label>
		<textarea class="form-control" id="desc"
			style="height: 100px" name="desc" required>{{  
       str_replace("<br/>","\n", old('desc', $product['desc'])) }}
      </textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

@endsection