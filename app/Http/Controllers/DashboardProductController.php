<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.products.index', [
            'title' => 'Products',
            'products' => Product::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.products.create', [
            'title' => 'Add Products'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:products'],
            'brand' => ['required', 'max:255'], 
            'type' => ['required', 'max:9'],
            'price' => ['required'], 
            'qty' => ['required', 'min:1'], 
            'desc' => ['required', 'max:255'], 
            'image' => 'image|file|max:5024'
        ]);
         $fileName=$_FILES['image']['name'];
         $fileTmpName=$_FILES['image']['tmp_name'];

        if($request->file('image')){
           $newFileName = 'product-images/'.uniqid().$fileName;
           move_uploaded_file($fileTmpName, 'storage/' . $newFileName);
            $validatedData['image'] = $newFileName;
        }

        $validatedData['price'] = preg_replace("/[^0-9]/", "", $validatedData['price']);
        $validatedData['desc'] = preg_replace("/\r\n|\r|\n/", '<br/>', str_replace("'","",$validatedData['desc']));
        Product::create($validatedData);
        return redirect('/dashboard/products')->with('success', 'New product has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
       return $products;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
         return view('dashboard.products.edit', [
            'title' => 'Edit Products',
            'product' => $product,
            'image' => 'image|file|max:5024'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
      $rules = [
            'brand' => ['required', 'max:255'], 
            'type' => ['required', 'max:10'],
            'price' => ['required'], 
            'qty' => ['required', 'min:1'], 
            'desc' => ['required', 'max:255'], 
            'image' => 'image|file|max:5024'
        ];

         if($request->name != $product->name){
            $rules['name'] = 'required|unique:products';
        }

        $fileName=$_FILES['image']['name'];
        $fileTmpName=$_FILES['image']['tmp_name'];

        $validatedData = $request->validate($rules);   

        $validatedData['price'] = preg_replace("/[^0-9]/", "", $validatedData['price']);
        $validatedData['desc'] = preg_replace("/\r\n|\r|\n/", '<br/>', str_replace("'","",$validatedData['desc']));

        if($request->file('image')){
            if($request->oldImage){
               unlink('storage/' . $request->oldImage);
            }
            $newFileName = 'product-images/'.uniqid().$fileName;
           move_uploaded_file($fileTmpName, 'storage/' . $newFileName);
            $validatedData['image'] = $newFileName;
        }
    
        Product::where('id', $product->id)->update($validatedData);
        
        return redirect('/dashboard/products')->with('success', 'Product has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image){
             unlink('storage/' . $product->image);
        }
        
        Product::destroy($product['id']);
        return redirect('/dashboard/products')->with('success', 'Product has been deleted!');
    }
}