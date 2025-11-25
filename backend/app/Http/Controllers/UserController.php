<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionHandler;
use App\Services\AuthService;
use Illuminate\Http\Request;

class UserController
{
    public $authService;

    public function __construct(AuthService $auth)
    {
        $this->authService = $auth;
    }

    public function signUp(Request $req)
    {
        $data = $req->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:6",
            "role_id" => "required"
        ]);

        return $this->authService->singUpService($data);
    }

    public function signIn(Request $req)
    {
        $data = $req->validate([
            "email" => "required",
            "password" => "required"
        ]);

        return $this->authService->signInService($data);
    }

    public function me()
    {
        return $this->authService->getMeService();
    }

    public function refresh(Request $req)
    {
        $token = $req->cookie('refresh_token');
        
        return $this->authService->refreshService($token);
    }
}
