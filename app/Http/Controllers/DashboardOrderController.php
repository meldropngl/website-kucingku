<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $orders= DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.id' ,'users.username', 'orders.image', 'products.name', 'orders.qty', 'products.price', 'orders.status', 'orders.updated_at')
            ->get();
         return view('dashboard.orders.index', [
            'title' => 'Orders',
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if($order->status === 'waiting'){
            $qty = DB::table('products')->where('id', $order->product_id)->pluck('qty')[0];
            $qty = $qty - $order->qty;
            $resource = [
                'status' => 'sending',
            ];

            $qty = [
                'qty' => $qty 
            ];
         Product::where('id', $order->product_id)->update($qty);
        }else{
            $resource = [
                'status' => 'arrived'
            ];
        }
        Order::where('id', $order->id)->update($resource);
        return redirect('/dashboard/orders')->with('success', 'Order has been accepted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
      
        $image = DB::table('orders')
                      ->where('image', $order->image)
                      ->count();
            $resource = [
                'status' => 'canceled'
            ];
            
         if($image === 1){
            if($order->image){
                unlink('storage/' . $order->image);
            }
        }
          Order::where('id', $order->id)->update($resource);
         return redirect('/dashboard/orders')->with('success', 'Order has been declined!');
    }
}