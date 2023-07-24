@extends('layouts.main')

@section('container')
<div class="container-fluid">
        <div class="container mt-4 mb-4 pt-4">
          <h3 class="fw-bold">Your Transaction</h3>
          <div class="col-md-12 w-100">
            <div class="row">
          @if(session()->has('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@endif
           @if(session()->has('failed'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						{{ session('failed') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@endif
  @if(!empty($orders[0]))
      @foreach($orders as $order )
					
                <div class="col-6 col-md-3">
                  <div class="card c-admin p-2 pb-0 shadow-sm bg-body rounded mt-4">
                    <img src="{{ asset('storage/'.$order->image) }}" width="100%"> 
                    <div class="text-center title">
                      <p class="m-0 nama_produk">{{ $order->name }}</p>
                      <p class="m-0" style=" font-size: 12px;">{{  'Rp. ' . number_format($order->qty*$order->price,2,'.','.'); }}</p>
                      <p>{{ $order->qty }}</p>
                       <p>{{ substr($order->updated_at,0, 10) }}</p>
                    </div>    
                    <div class="text-center action mb-3">
											@if($order->status === 'waiting')
                      <form action="/transaction/{{ $order->id }}" method="post" onsubmit="return confirm('Are you sure you want to cancel this transaction?');">
                      @csrf
                      <input type="text" value="{{ $order->orderImage }}" name="image" hidden>
                      <input type="text" value="{{ $order->id }}" name="id" hidden>
                      <button class="more btn btn-danger mb-2">Batal</button>
                      </form>
											<button class="more btn btn-primary" type="button" disabled>
  										<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
 											 Waiting...
										</button>
    
											@elseif($order->status === 'sending')
                      <p style="color:red;"><i>*Can't be cancelled</i></p>
											<button class="more btn btn-success" type="button" disabled>
  										<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
 											 Sending...
										</button>
										@elseif($order->status === 'canceled')
                    <p style="color:red;font-size:12px;"><i>*Screen shoot the transaction then contact us via <br> <strong> WA: +62 819-3145-5863</strong></i></p>

                    @elseif($order->status === 'arrived')
                     <p style="color:green;font-size:14px;">Your order has arrived</p>
											<form action="/transaction/{{ $order->id }}" method="post" onsubmit="return confirm('Are you sure you want cancel this transaction?');">
                         @csrf
                      <input type="text" value="{{ $order->orderImage }}" name="image" hidden>
                      <input type="text" value="{{ $order->id }}" name="id" hidden>
                      <button class="more btn btn-dark">Confirmation</button>
                      </form>
											@else
                        <p style="color:green;font-size:14px;">Done</p>
                        <a href="/product/{{ $order->product_id }}" class="more bg-success mb-1" >Buy Again</a>
                      @endif
                    </div>
                  </div>
                </div>  
          @endforeach
			@else
                   <div class="row h-100 w-100 mx-auto" style=" min-height: 50vh ;">
                    <div class="col-md-12 mx-auto my-auto text-center text-muted">
                      <h4>You have not made a transaction</h4>
                    </div>
                  </div>
				@endif
              </div>
            </div> 
          </div>
        </div>
      </div>
@endsection