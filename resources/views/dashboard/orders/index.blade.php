@extends('dashboard.layouts.main')

@section('container')
 				 <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Orders</h1>
          </div>
					
					@if(session()->has('success'))
					<div class="alert alert-success" role="alert">
						{{ session('success') }}
					</div>
					@endif

						<div class="small">
            <table  id="example" class="table table-striped" width="100%">
              <thead>
                <tr>
                  <th scope="col">#</th>
									<th scope="col">Date</th>
                  <th scope="col">Image</th>
                  <th scope="col">Username</th>
                  <th scope="col">Name</th>
									<th scope="col">Qty</th>
                  <th scope="col">Price</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
								@foreach ($orders as $order)
 								<tr>
                  <td>{{ $loop->iteration }}</td>
									<td>{{ $order->updated_at }}</td>
                  <td>
										<img src="{{ asset('storage/'.$order->image) }}" onerror="this.onerror=null;this.src='/storage/order-images/default.png';" style="width:100px; height:100px; object-fit:cover"/>
									</td>
                  <td>{{ $order->username }}</td>
									<td>{{ $order->name }}</td>
                  <td>{{ $order->qty }}</td>
									<td>{{ 'Rp. ' . number_format($order->qty * $order->price,2,'.','.') }}</td>
									 <td>
											<p 
											@if($order->status === 'waiting')
											style="color:#0d6efd;"
											@elseif($order->status === 'sending')
											style="color:grey;"
											@elseif($order->status === 'arrived')
											style="color:#54B4D3;"
											@elseif($order->status === 'successed')
											style="color:green;"
											@else
											style="color:red;"
											@endif
											>{{ $order->status }}</p>
									</td>
									 
									<td>
									@if($order->status === 'waiting')
										<form class="d-inline" action="/dashboard/orders/{{ $order->id }}" method="post">
										@method('put')
										@csrf
										<input type="hidden" name="oldImage" value="{{ $order->id }}">
										<button class="more badge bg-success border-0 fs-6 mb-2" onclick="return confirm('Are you sure accept this transaction?')">Accept</button>
									</form>
									
									<form class="d-inline" action="{{ route('orders.destroy', $order->id) }}" method="post">
										@method('delete')
										@csrf
										<input type="hidden" name="image" value="{{ $order->image }}">
										<button class="more badge bg-danger border-0 fs-6" onclick="return confirm('Are you sure?')">Decline</button>
										</form>

										@elseif($order->status === 'sending')
										<form class="d-inline" action="/dashboard/orders/{{ $order->id }}" method="post">
										@method('put')
										@csrf
										<button class="more badge bg-dark border-0 fs-6 mb-2" onclick="return confirm('Are you sure?')">Confirm</button>
										</form>
										@else
										<button class="more badge bg-secondary border-0 fs-6 mb-2"> - </button>
										@endif
									</td>
									
                </tr>
								@endforeach
              </tbody>
            </table>
          </div>
@endsection