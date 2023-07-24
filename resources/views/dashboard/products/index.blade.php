@extends('dashboard.layouts.main')

@section('container')
 				 <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Products</h1>
          </div>
					
					@if(session()->has('success'))
					<div class="alert alert-success" role="alert">
						{{ session('success') }}
					</div>
					@endif

          
						<a href="/dashboard/products/create" class="btn btn-light mb-lg-2"><i class="bi bi-clipboard-plus"></i> Create Product</a>

						<div class="small">
            <table  id="example" class="table table-striped" width="100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Image</th>
                  <th scope="col">Name</th>
                  <th scope="col">Brand</th>
									<th scope="col">Type</th>
                  <th scope="col">Price</th>
									<th scope="col">Qty</th>
									<th scope="col">Description</th>
									<th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
								@foreach ($products as $product)
 								<tr>
                  <td>
										{{ $loop->iteration }}</td>
                  <td>
										<img src="{{ asset('storage/'.$product['image']) }}" onerror="this.onerror=null;this.src='/storage/product-images/default.png';"
										style="width:100px; height:100px; object-fit:cover">
										</td>
                  <td>{{ $product['name'] }}</td>
                  <td>{{ $product['brand'] }}</td>
									<td>{{ $product['type'] }}</td>
									<td>{{  'Rp. ' . number_format($product['price'],2,'.','.'); }}</td>
                  <td>{{ $product['qty'] }}</td>
									<td><?= $product['desc']; ?></td>
									<td>
										<a href="/dashboard/products/{{ $product['id'] }}/edit" class="badge bg-success fs-6 mb-lg-2"><i class="bi bi-pencil-square"></i></a>
										<form class="d-inline" action="{{ route('products.destroy', $product['id']) }}" method="post">
										@method('delete')
										@csrf
										<button class="badge bg-danger border-0 fs-6" onclick="return confirm('Are you sure?')"><i class="bi bi-trash-fill "></i></button>
										</form>
									</td>
                </tr>
								@endforeach
              </tbody>
            </table>
          </div>
@endsection