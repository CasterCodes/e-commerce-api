<?php 

namespace App\Http\Library;


trait AuthorizeRequest {
    protected function restrictTo($roles, $user) {
        $repsonse = in_array($user->role, $roles) ? true : false;
        return $repsonse;
    }
}