<?php 
$jumlah=1;
if(isset($_COOKIE['shopping_cart'])){
	$cookie_data=stripcslashes($_COOKIE['shopping_cart']);
	$cart_data=json_decode($cookie_data, true);
	 foreach($cart_data as $keys => $products){
		if($products['code']==$product['id'])
             $jumlah=$products['qty'];
	}
}
	 ?>
@extends('layouts.main')

@section('container')
		@if(session()->has('failed'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						{{ session('failed') }}
					 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
		@endif
<div class="row">
       <div class="col-md-10 my-auto mx-auto border p-4 shadow-sm rounded bg-white mb-3 ">
         <div class="col-md-12">
          <h3 class="fw-bold text-center"><?= $product['name']; ?></h3>
           <div class="row pt-3">
             <div class="col-md-6 my-auto text-center text-md-start">
              <img src="{{ asset('storage/'.$product['image']) }}" width="70%">
             </div>
             <div class="col-md-6 my-auto">
              <div class="col-md-12 text-center text-md-start">
                <p class="fw-bold text-justify">Product Detail</p>
                <p><span>Name : </span><?= $product['name']; ?></p>
                <p><span>Brand : </span><?= $product['brand']; ?></p>
                <p><span>Price : </span>{{  'Rp. ' . number_format($product['price'],2,'.','.'); }}</p>
                <p><span>Type : </span><?= $product['type']; ?></p>
                
              </div>
              <div class="col-md-12 text-center text-md-start">
                <p class="fw-bold">Description</p>
                <p><?= $product['desc']; ?></p>
              </div>
              <div class="col-md-12 text-center text-md-start">
                <div class="row">
                  <div class="col-xs-6 text-center text-md-start">
										<?php if($product['qty']>0): ?>
                    <form action="/product/{{ $product['id'] }}" method="post">
											   @csrf
                      <input type="hidden" name="id" value="<?= $product['id'];?>">
                      <p>Quantity : </p><input type="number" name="qty" class="inputForm w-50 mx-auto mx-md-0 d-block text-md-start text-center" 

											value="{{ $jumlah }}" min="1" max="<?= $product['qty'];?>" >
                      <button type="submit" class="btn btn-keranjang mt-2 mb-2 btn-success">Add to Cart</button>
                    </form>

										<?php else: ?>
											  <button type="button" class="btn btn-danger btn-keranjang mt-2 mb-2">Sold Out</button>
									<?php endif; ?>
                  </div>
                  
                </div>
              </div>
             </div>
           </div>
             
         </div>
       </div>
     </div>
@endsection