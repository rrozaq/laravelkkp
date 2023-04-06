<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserLoginResource;
use App\Http\Resources\User\UserRegisterResource;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // get credentials from request
        $credentials = $request->only('email', 'password', 'is_active');
        $credentials['is_active'] = 1;

        // attempt to verify the credentials and create a token for the user
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // all good so return the token
        return new UserLoginResource((object)$this->responWithToken($token));
    }

    public function register(UserRegisterRequest $request)
    {
        try {
            // create user
            $user = User::create($request->validated());

            // send otp to email
            $otp = self::createOTP();
            $client = new \GuzzleHttp\Client();
            $client->request('POST', 'https://script.google.com/macros/s/AKfycbxFNsyMXW8chGL8YhdQE1Q1yBbx5XEsq-BJeNF1a6sKoowaL_9DtcUvE_Pp0r5ootgMhQ/exec', [
                'json' => [
                    'email' => $request->email,
                    'subject' => 'Konfirmasi Pendafataran Akun',
                    'message' => 'Kode OTP anda adalah ' . $otp,
                    'token' => '1dy09eODblmBUCTnIwiY-hbXdzCpZC3jyR4l0ZJgqQqO9L7J3zsZOobdJ'
                ]
            ]);

            // save otp to database
            $user->otp()->create([
                'otp' => $otp
            ]);
            
            return new UserRegisterResource($user);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifOtp(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user->otp->otp == $request->otp) {
                $user->otp->delete();
                $user->permohonanRegistrasi()->create([
                    'status' => 'pending'
                ]);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Verifikasi berhasil'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Verifikasi gagal'
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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
