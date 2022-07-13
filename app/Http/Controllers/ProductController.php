<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $body = $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'countInStock' => ['required'],
            'brand' => ['required'],
        ]);

       $body['user_id'] = 1;

       $product = Product::create($body);

       return  response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return  response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response()->json(null, 204);
    }
    /**
     * Search for a specific product in the database
     * @param 
     */

    public function search($query) {
         $products = Product::where('name', 'like', "%" .$query. "%")->where('description', 'like',"%" .$query. "%" )->get();

         return response()->json($products, 200);
    }
}
