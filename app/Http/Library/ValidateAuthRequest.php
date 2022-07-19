<?php

namespace App\Http\Library;

trait ValidateAuthRequest {
    protected function signupValidationRules(): array {
        return  [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email|email',
            'password' => 'required|string|confirmed',
        ];
    }


    protected function signinValidationRules(): array {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }
}