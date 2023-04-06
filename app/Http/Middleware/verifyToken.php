<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get token from header
        $token = $request->header('Authorization');

        // check if token is empty
        if (empty($token)) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak ditemukan'
            ]);
        }

        // check if token is valid
        if($token == '123456') {
            return $next($request);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid'
            ]);
        }
    }
}
