@extends('layouts.main')

@section('container')
<div class="container-fluid">
         <div class="row w-100 my-5 mx-auto">
           <div class="col-md-6 bg-white shadow-sm border rounded mx-auto">
              <h3 class="fw-bold pt-4 text-center">Payment</h3>
              <form action="/invoice/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
								 @csrf
							@foreach($products AS $product)
								<?php  $n = $loop->iteration ; ?>
							<input type="hidden" name="product_id{{ $loop->iteration }}" value="{{ $product['id'] }}">
							<input type="hidden" name="qty{{ $loop->iteration }}" value="{{ $product['qty'] }}">
							@endforeach
							<input type="hidden" name="n" value="{{ $n }}">
							<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
						<div class="mb-3">
    			<label for="username" class="form-label">Username :</label>
    			<input type="text" class="form-control" id="username" name="username" value="{{ auth()->user()->username }}" readonly>
  				</div>

					<div class="mb-3">
    			<label for="total" class="form-label">Bill :</label>
    			<input type="text" id="total" class="form-control" name="total" value="{{  'Rp. ' . number_format($total,2,'.','.'); }}"readonly>
  				</div>
					<div class="mb-3">
    			<label for="address" class="form-label">Complete Address :</label>
					<textarea class="form-control" name="address" id="address" cols="30" rows="5" required>@if(auth()->user()->address){{ auth()->user()->address }}@endif</textarea>
  				</div>

            <div class="mb-3">
							<label for="image" class="form-label">
						Proof of payment (Rek: 20552011040 / a.n: Valen) :</label>
             <div class="input-group flex-nowrap pt-4 ps-5 pe-5">
              	<img src="" class="img-thumbnail mb-2" style="width:120px;display:none;" id="img-preview">
             </div>
								<input  id="image" type="file" class="form-control"  aria-describedby="addon-wrapping" autocomplete="off" name="image" onchange="previewImage();" required >
              </div>
                
                <div class="ps-5 pe-5 pb-5"><button class="btn btn-dark login form-control "type="submit">Konfirmasi</button></div> 
              </form>
           </div>
         </div>
     </div>

		 <script>
			function previewImage() {
    const gambar = document.querySelector("#image");
    const imgPreview = document.querySelector("#img-preview");
    imgPreview.style.display = "block";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(gambar.files[0]);

    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}
		 </script>
@endsection