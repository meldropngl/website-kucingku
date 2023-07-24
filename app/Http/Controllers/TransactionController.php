<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(){
        $user = auth()->user()->id;

    $orders= DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.id', 'orders.product_id', 'products.image as image', 'orders.image as orderImage', 'products.name', 'orders.qty', 'products.price', 'orders.status', 'orders.updated_at')
            ->where('orders.user_id', '=', $user)
            ->get();

        return view('transaction.index', [
            'title' => 'Transaction',
            'orders' => $orders
        ]);

     if(empty(Order::where('user_id', '=', $user)->first())){
            $isEmpty="true";
            return view('transaction.index', [
            'title' => 'Transaction',
            'isEmpty' => $isEmpty
        ]);
        }
    }

    public function store(Request $request){
    $status = DB::table('orders')->where('id', $request->id)->pluck('status')[0];

    if($status==='waiting'){
        $image = DB::table('orders')
                      ->where('image', $request->image)
                      ->count();
            $resource = [
                'status' => 'canceled'
            ];
          
         if($image <= 1){
            if($request->image){
                  unlink('storage/' . $request->image);
            }

         Order::where('id', $request->id)->update($resource);
         return redirect('/transaction')->with('success', 'Order berhasil dibatalkan!');
        }
    }elseif($status === 'arrived'){
         $resource = [
            'status' => 'successed'
        ];
    Order::where('id', $request->id)->update($resource);
    return redirect('/transaction')->with('success', 'Order berhasil diterima!');
    }
      return redirect('/transaction')->with('failed', 'Aksi Gagal!');
    }
}