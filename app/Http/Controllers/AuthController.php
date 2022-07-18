<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function signup(Request $request) {
         $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
         ]);

         $user = User::create([
              'name' => $data['name'],
              'email' => $data['email'],
              'password' => bcrypt($data['password'])
         ]);

         $token = $user->createToken('e-commerce-token')->plainTextToken;

         $response = [
            'user' => $user,
            'token' => $token
         ];

         return response()->json($response, 201);

    }

    public function signin (Request $request) {
         $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
         ]);

         $user = User::where('email', $data['email'])->first();

         if(!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'You provided wrong credentials']);
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
