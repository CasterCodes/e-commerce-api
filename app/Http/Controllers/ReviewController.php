<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return response()->json($product->reviews()->latest()->get(), 200);
    }

    /**
     * storee a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'comment' => 'required|string',
            'rating' => 'required|integer',
        ]);
        
        if(!$validator->passes()) {
            return response()->json($validator->errors(), 400);
        }
        
        $reviewToCreate = [
            'title' => $validator->validated()['title'],
            'comment' => $validator->validated()['comment'],
            'rating' =>$validator->validated()['rating'],
            'user_id' => auth()->user()->id,
            'product_id' => $product->id,
        ];  
        
        if(auth()->user()->hasReviewed($product)) {
            return response()->json([
                "status" => "fail",
                "message" => "You have already created review for this product"
            ], 400);
        }
        
        
        if(!$product) {
            return response()->json([
                "status"=>"fail",
                "message" => "There is not product with that id"
            ], 400);
        }


        Review::create($reviewToCreate);

        $reviews = Review::all();

        $totalReviews = $reviews->reduce(function($current, $item){
             return $item->rating + $current;
        }, 0);

        $product->numReviews = $reviews->count();

        $product->rating =  ((int)$totalReviews / $reviews->count());

        $product->save();

        return response()->json([
            "status" => "success",
            "message" => "Review was created as successfully",
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {

        if(!$review->reviewOwnedBy(auth()->id())) {
             return response()->json([
            'status' =>'fail',
            'message' => 'You not allowed to update this review'
             ], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'comment' => 'string'
        ]);

        if(!$validator->passes()) {
              return response()->json($validator->errors(), 400);
        }

        $review->update($validator->validated());

        return response()->json([
            'status' => 'success'
        ], 201);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if(!$review->reviewOwnedBy(auth()->id())) {
             return response()->json([
            'status' =>'fail',
            'message' => 'You not allowed to update this review'
             ], 400);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully'
        ]);
    }
}
