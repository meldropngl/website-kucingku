@extends('layouts.main')

@section('container')
@if(!request('q')&&!request('type'))
<section id="header">
<div class="row w-100 pt-3 mx-auto">
            <div class="col-md-8 mx-auto">
              <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item">
                  <img src="/img/banner.jpeg" class="d-block w-100 h-30" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Shop Now!!!</h5>
                    <p>We have good product</p>
                  </div>
                </div>
                <div class="carousel-item active">
                  <img src="/img/banner1.jpeg" class="d-block w-100 h-30" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Happy Cat</h5>
                    <p>Lot of happy and healty cat in here.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="/img/banner2.jpeg" class="d-block w-100 h-30" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Many Choice</h5>
                    <p>Have many choice for your cat</p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
            </div>
          </div>
          <div class="row">
            <h5 class="text-center pt-4 fw-bold" style="color: #dda93a;">Best seller Brand</h5>
            <div class="col-md-18 text-center pt-3">
              <img src="/img/logobrand1.jpeg" width="20%">
              <img src="/img/logobrand2.jpeg" width="20%">
              <img src="/img/logobrand3.jpeg" width="20%">
              <img src="/img/logobrand4.jpeg" width="20%">
            </div>
          </div>
	</section>
@endif

  	<section id="produk">
				<div class="contaiter-fluid">
					<div class="container @if(request('q')||request('type'))mt-5 @else mt-4 @endif mb-5">
						<div class="row">
							<div class="col-md-6">
                @if(request('q'))
								<h2 class="fw-bold text-center text-lg-start">Looking For</h2>
               @elseif(request('type'))
                  <h2 class="fw-bold text-center text-lg-start" style="text-transform:capitalize  ;">{{ request('type') }}</h2>
                 @else
                     <h2 class="fw-bold text-center text-lg-start " style="color: #dda93a;">All Products</h2>
                @endif
							</div>
							<div class="col-md-6">
								<form class="d-flex" action="/" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search products" aria-label="Search" name="q" autocomplete="off" value="{{ request('q') }}">
              </form>
							</div>
          <div class="col-md-12">
            <div class="row">
    @if(!empty($products[0]))
          @foreach($products as $product)
                <div class=" col-6 col-md-3">
                 <div class="card c-user p-2 shadow-sm bg-body rounded mt-4" id="card">
                    <img src="{{ asset('storage/'.$product->image) }}" width="100%">
                    <div class="text-center title">
                      <p class="m-0 nama_produk"><?= $product->name; ?></p>
                      <p class="mb-3 harga">{{  'Rp. ' . number_format($product->price,2,'.','.'); }}</p>
                    </div>    
                    @if($product->qty > 0)
                    <div class="text-center action">
                      <a href="/product/{{ $product->id }}" class="more mb-1 " style="background-color: #dda93a;">Details</a>
                    </div>
                  @else
                       <div class="text-center action">
                      <button type="button" class="more btn btn-danger mb-1">Sold Out</button>
                    </div>
                   @endif
                  </div>
                  </div>
          @endforeach
           @else
            <div class="row h-100 w-100 mx-auto" style=" min-height: 50vh ;">
                    <div class="col-md-12 mx-auto my-auto text-center text-muted">
                       @if(request('q'))
                      <h4>what you are looking for is '{{ request('q') }}', it doesn't exist</h4>
                      @else
                         <h4>There are no products yet</h4>
                      @endif
                  </div>
                  </div>
           @endif
                </div>
            </div>
            
          </div>
							</div>
						</div>
					</div>
				</div>
			</section>
@endsection
