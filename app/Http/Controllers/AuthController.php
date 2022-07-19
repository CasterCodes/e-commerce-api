<?php

namespace App\Http\Controllers;

use App\Http\Library\ValidateAuthRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ValidateAuthRequest;
   
    public function signup(Request $request) {

         $validator = Validator::make($request->all(), $this->signupValidationRules());

         if(!$validator->passes()) {
            return response()->json($validator->errors(), 400);
         }

         $user = User::create([
            'name' => $validator->validated()['name'],
            'email' => $validator->validated()['email'],
            'password' => bcrypt($validator->validated()['password'])
         ]);

         $token = $user->createToken('e-commerce-token')->plainTextToken;

         $response = [
            'user' => $user,
            'token' => $token
         ];

         return response()->json($response, 201);

    }

    public function signin (Request $request) {
         
         $validator = Validator::make($request->all(), $this->signinValidationRules());

          if(!$validator->passes()) {
            return response()->json($validator->errors(), 400);
         }

         $user = User::where('email', $validator->validated()['email'])->first();

         if(!$user || !Hash::check($validator->validated()['password'], $user->password)) {
            return response()->json(['message' => 'You have provided wrong crenditails']);
         }

          $token = $user->createToken('e-commerce-token')->plainTextToken;

          $response = [
            'user' => $user,
            'token' => $token,
          ];

          return response()->json($response, 200);
    }

    public function logout () {
        auth()->user()->tokens()->delete();

        return response(null, 200);
    }

}
