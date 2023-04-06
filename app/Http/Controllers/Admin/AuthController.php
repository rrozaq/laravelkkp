<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\AdminLoginResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // get credentials from request
        $credentials = $request->only('email', 'password');

        // attempt to verify the credentials and create a token for the user
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // all good so return the token
        return new AdminLoginResource((object)$this->responWithToken($token));
    }

    protected function responWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ];
    }
    
    static function createOTP()
    {
        $number = strval(rand(100000000, 999999999));
        return substr($number, 0, 4);
    }
}
