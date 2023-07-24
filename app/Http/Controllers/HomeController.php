<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
      public function index()
    {
     
        $products =  DB::table('products')
         ->orderBy('qty' ,'DESC', 'updated_at', 'DESC');

        if(request('q')){
            $products->where('name', 'like', '%'.request('q').'%')
            ->orWhere('brand', 'like', '%'.request('q').'%')
             ->orderBy('qty' ,'DESC', 'updated_at', 'DESC');
        }elseif(request('type')){
            $products->where('type', '=',ucfirst(request('type')))
             ->orderBy('qty' ,'DESC', 'updated_at', 'DESC');
        }

        return view('home', [
            'title' => 'Home',
            'products' => $products->get(),
        ]);
     }
}