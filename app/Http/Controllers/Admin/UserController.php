<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\PermohonanRegistrasi;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\PermohonanRegistrasiResource;
use App\Models\User;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin','permission:verifikasi-users|delete-users']);
    }

    public function permohonanRegistrasi()
    {
        // get user by verifikasi otp
        $users = PermohonanRegistrasi::with('user')->where('status', 'pending')->get();

        return PermohonanRegistrasiResource::collection($users)->additional([
            'status' => true,
            'message' => 'Berhasil mendapatkan data user'
        ]);
    }

    public function verifikasiAkun(Request $request)
    {
        try {
            // get user by id
            $user = PermohonanRegistrasi::with('user')->where('user_id', $request->user_id)->first();

            // update status
            $user->update([
                'status' => 'verified'
            ]);

            // update user
            $user->user->update([
                'is_active' => 1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil verifikasi akun'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal verifikasi akun'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            // get user by id
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil hapus akun'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal hapus akun'
            ]);
        }
    }
}