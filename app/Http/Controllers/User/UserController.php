<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KapalIkan;
use App\Models\User;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:User|Admin','permission:edit-users'], ['only' => ['update']]);
    }

    public function profile()
    {
        $user = auth('api')->user();
        $kapalIkan = KapalIkan::where('user_id', 6)->first();

        if($kapalIkan) {
            if($kapalIkan->status == 'approved') {
                unset($kapalIkan->catatan);
                $user->kapal_ikan = $kapalIkan;
                $kapalIkan->status = 'Kapal Layak Berlayar';
            }

            if($kapalIkan->status == 'rejected') {
                $user->kapal_ikan = $kapalIkan;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data user',
            'data' => $user
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if($user) {
            $user->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah data user',
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal mengubah data user'
        ]);
    }
}