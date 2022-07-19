<?php

namespace App\Http\Controllers;

use App\Http\Library\AuthorizeRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use AuthorizeRequest;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check if user is authorized to create product
        return response()->json([
            'categories' => Category::all()
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
        //
         if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
               
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
            'description' => 'required|string'
        ] );

        if(!$validator->passes()) {
            return response()->json($validator->errors(), 400);
        }

        $category = [
            'name' => $validator->validated()['name'],
            'description' => $validator->validated()['description'],
            'user_id' =>auth()->user()->id
        ];

        $createdCategory = Category::create($category);

        return response()->json($createdCategory, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
         return  response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
               
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|',
            'description' => 'string'
        ]);

        if(!$validator->passes()) {
            return response()->json($validator->errors(), 400);
        }

       $category->update($validator->validated());

        return response()->json($category, 200);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        if(!$this->restrictTo(['admin'], auth()->user())) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
               
            ], 401);
        }

        $category->delete();

        return response()->json(['message' => "Category deleted"], 200);
    }
}
