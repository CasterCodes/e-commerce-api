<?php

namespace App\Http\Controllers;

use App\Http\Library\AuthorizeRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizeRequest;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::latest()->filter(request(['search', 'brand', 'category']))->paginate(6);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if user is authorized to create product
        if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',   
            ], 401);
        }

        
        // validation
      $body = $request->all();

       $body['user_id'] = 1;

       $product = Product::create($body);

       $response = [
        'product' => $product,

       ];

       return  response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $product  = '';

        if($request->query('include_reviews')) {
             $product = Product::with('reviews')->find($id);
             return  response()->json($product, 200);
        }

        $product = Product::find($id);
        
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
         if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action'
            ], 400);
        }

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
         if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
             
            ], 401);
        }
        
        // delete product
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
