<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\KapalIkanController as UserKapalIkanController;
use App\Http\Controllers\Admin\KapalIkanController as AdminKapalIkanController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\DataKapalController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    
    // User
    Route::group(['prefix' => 'user'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('verifikasi_otp', [AuthController::class, 'verifOtp']);

        Route::group(['middleware' => 'auth:api'], function () {
            // profile
            Route::get('profile', [UserController::class, 'profile']);
            Route::post('update/profile/{id}', [UserController::class, 'update']);
            
            // pendaftaran kapal ikan
            Route::post('daftar/kapal-ikan', [UserKapalIkanController::class, 'store']);
            Route::post('update/kapal-ikan/{id}', [UserKapalIkanController::class, 'update']);
        });
    });
    
    // Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', [AdminAuthController::class, 'login']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('permohonan_registrasi', [AdminUserController::class, 'permohonanRegistrasi']);
            Route::post('verifikasi_akun', [AdminUserController::class, 'verifikasiAkun']);
            Route::delete('delete/akun/{id}', [AdminUserController::class, 'delete']);

            // kapan ikan
            Route::get('kapal-ikan', [AdminKapalIkanController::class, 'getkapalIkan']);
            Route::post('kapal-ikan/verifikasi', [AdminKapalIkanController::class, 'verifikasiKapalIkan']);
            Route::delete('delete/kapal-ikan/{id}', [AdminKapalIkanController::class, 'delete']);
        });
    });

    // api public
    Route::group(['middleware' => ['verifyToken']], function () {
        Route::get('data-kapal', [DataKapalController::class, 'getDataKapal']);
    });

});
