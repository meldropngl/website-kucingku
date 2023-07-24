<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
     public function index(Request $request){
        if(isset($_COOKIE['shopping_cart'])){
            $cookie_data=stripcslashes($_COOKIE['shopping_cart']);
	        $cart_data=json_decode($cookie_data, true);
            foreach($cart_data as $keys => $product){
             $tempCart = array(
                'id' => $product['code'],
                'qty' => $product['qty'],
             );
               $products[] = $tempCart;
            }
        }
        return view('invoice.index', [
            'title' => 'Invoice',
            'total' => $request['total'],
            'products' => $products
        ]);
    }

       public function buy(Request $request){
     $user = auth()->user();

        $validatedData = $request->validate([
            'image' => 'image|file|max:5024'
        ]);

        $fileName=$_FILES['image']['name'];
        $fileTmpName=$_FILES['image']['tmp_name'];

        if($request->file('image')){
           $newFileName = 'order-images/'.uniqid().$fileName;
           move_uploaded_file($fileTmpName, 'storage/' . $newFileName);
            $validatedData['image'] = $newFileName;
        }

        for($i=1; $i <= $request['n']; $i++){
            $id = 'product_id'.$i;
            $qty = 'qty'.$i;
            $tempCart = array(
                'user_id' => $request['user_id'],
                'product_id' => $request[$id],
                'image' => $validatedData['image'],
                'qty' => $request[$qty],
             );
             $order[]=$tempCart;
        }

        for($j=0; $j < $request['n']; $j++){
          Order::create($order[$j]);
        }
    
        if($request->address != $user->address){
            $address = [
             'address' =>  $request['address']
            ];
            User::where('id', $user->id)->update($address);
        }

        setcookie('code', '', time()-(9000000*30),"/");
	    setcookie('shopping_cart', '', time()-(9000000*30),"/");
        return redirect('/transaction')->with('success', 'Produk berhasil diorder!');
    }

}