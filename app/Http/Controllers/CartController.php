<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
  public function index()
  {
    if(isset($_COOKIE['shopping_cart']))
    {
		$cookie_data=stripcslashes($_COOKIE['shopping_cart']);
	    $cart_data=json_decode($cookie_data, true);
        $total=0;
        $items=0;
        $aman=false;
        
      foreach($cart_data as $keys => $products)
      {
         $code=$products['code'];
         $qty=$products['qty'];
         $qtySet=0;
         $codeSet='';

        // cek apakah stok ada yang habis
       $qtydb= DB::table('products')
            ->select('products.qty')
            ->where('products.id', '=', $code)
            ->get()[0];
         if($qty > $qtydb->qty && $qtydb->qty != 0)
         {
	        $item_id_list= array_column($cart_data, 'code');

			if(in_array($code, $item_id_list))
            {
			    foreach($cart_data as $keys => $product)
                {
					if($cart_data[$keys]["code"]== $code)
                    {
							// jumlah barangnya bisa di masukin di sini
							$cart_data[$keys]['qty']=Product::find($code)['qty'];
                            $qtySet = Product::find($code)['qty'];
                            $codeSet = $code;
					}
				}
			}
        }elseif(Product::find($code)['qty'] === 0)
        {
            unset($cart_data[$keys]);
			$item_data = json_encode($cart_data);
			setcookie('code', hash('sha256', $item_data), time()+(86400*30),"/");
			setcookie('shopping_cart', $item_data, time()+(86400*30),"/");
        }else{
            $codeSet = $code;
            $qtySet = $qty;
        }

        $tempCart = array(
            'id' => $codeSet,
            'image' => Product::find($codeSet)['image'],
            'name' => Product::find($codeSet)['name'],
            'qty' => $qtySet,
            'price' => Product::find($codeSet)['price'],
        );
    
        $setCart[] = $tempCart;
        $total=$total+Product::find($codeSet)['price']*$qtySet;
        $items=$items+$qtySet;
    }
        if(!empty($setCart)){
            return view('cart.index', [
                'title' => 'Cart',
                'products' => $setCart,
                'total' => $total,
                'items' => $items,
                'isEmpty' => 'false'
            ]);
        }else{
        return view('cart.index', [
            'title' => 'Cart',
            'isEmpty' => 'true'
         ]);
        }
    }

    return view('cart.index', [
            'title' => 'Cart',
            'isEmpty' => 'true'
    ]);

 }

  public function deleteCart(Request $request){
    $cookie_data=stripcslashes($_COOKIE['shopping_cart']);
	$cart_data=json_decode($cookie_data, true);
	foreach($cart_data as $keys=>$product){
		if($cart_data[$keys]['code']==$request['id']){
			unset($cart_data[$keys]);
			$item_data = json_encode($cart_data);
			setcookie('code', hash('sha256', $item_data), time()+(86400*30),"/");
			setcookie('shopping_cart', $item_data, time()+(86400*30),"/");
            return redirect('/cart')->with('success', 'The product has been successfully removed from the cart!');
		}
	}
    return redirect('/cart')->with('failed', 'The product failed to be removed from the cart!');
}


}