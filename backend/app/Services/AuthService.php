<?php

namespace App\Services;

use App\Exceptions\ExceptionHandler;
use App\Repositories\UserRepo;
use App\Utils\TokenManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public $user;
    public $token;
    public function __construct(UserRepo $user, TokenManager $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function singUpService($data)
    {
        $exist = $this->user->findCredetialEmail($data["email"]);

        if ($exist) {
            throw new ExceptionHandler('email has been taken', 402);
        }

        $data["password"] = Hash::make($data["password"]);

        $result = $this->user->createUser($data);

        return response()->json(["message" => "succes to register $result->name"]);
    }

    public function signInService($data)
    {
        $exist = $this->user->findCredetialEmail($data["email"]);

        if (!$exist) {
            throw new ExceptionHandler("Email doesnt exist {$data["email"]}", 404);
        }

        $check = Hash::check($data["password"], $exist->password);

        if (!$check) {
            throw new ExceptionHandler("Password incorrect", 401);
        }

        $accesToken = $this->token->createAccesToken($exist);
        $refreshToken = $this->token->createRefreshToken($exist);

        return response()->json([
            "message" => "succes Login",
            "data" => $accesToken
        ])->withCookie(
            cookie(
                "refresh_token",
                $refreshToken,
                6 * 24 * 7,
                "/",
                null,
                true,
                true,
                false,
                "Strict"
            )
        );
    }

    public function getMeService()
    {
        return response()->json(Auth::user());
    }

    public function refreshService($data)
    {
        $dataUser = $this->token->parseToken($data);
        $newAccesToken = $this->token->createAccesToken($dataUser);
        return response()->json(["data" => $newAccesToken]);
    }
}
