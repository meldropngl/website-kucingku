<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Product;

class ProductController extends Controller
{
     public function index($id){
        return view('product.index', [
            'title' => 'Product',
            'product' => Product::find($id)
        ]);
    }

     public function cart(Request $request)
    {   
        if($request['qty'] <= Product::find($request['id'])){
	    $code=$request['id'];
	    $qty=$request['qty'];
	    if(!empty($code)&&$qty>0){
		    if(isset($_COOKIE['shopping_cart'])){
				$cookie_data=stripcslashes($_COOKIE['shopping_cart']);
				$cart_data=json_decode($cookie_data, true);
				}else{
					$cart_data=array();
				}
		    $item_id_list= array_column($cart_data, 'code');

			if(in_array($code, $item_id_list)){

					foreach($cart_data as $keys => $product){
						if($cart_data[$keys]["code"]== $code){
							// jumlah barangnya bisa di masukin di sini
							$cart_data[$keys]['qty']=$qty;
						}
					}
					}else{
						$item_array= array(
							'code'=>$code,
							'qty'=>$qty
					);
					$cart_data[]=$item_array;
					}
		$item_data=json_encode($cart_data);
		setcookie('code', hash('sha256', $item_data), time()+(86400*30),"/");
		setcookie('shopping_cart', $item_data, time()+(86400*30),"/");
        
		 return redirect('/cart')->with('success', 'Product successfully added to cart!');
		}
    }else{  
	    return redirect('/product')->with('failed', 'Failed to add to cart, because product stock is limited!');
    }
}
}