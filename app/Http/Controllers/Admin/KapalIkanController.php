<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KapalIkan;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\KapalIkanResource;

class KapalIkanController extends Controller
{
    public function getkapalIkan()
    {
        // get kapal ikan status pending
        $kapalIkan = KapalIkan::with('user')->where('status', 'pending')->get();

        return KapalIkanResource::collection($kapalIkan)->additional([
            'status' => true,
            'message' => 'Berhasil mendapatkan data kapal ikan'
        ]);
    }

    public function verifikasiKapalIkan(Request $request)
    {
        try {
            // get user by id
            $user = KapalIkan::where('id', $request->kapal_id)->first();

            if($request->status == 'rejected') {
                // update status
                $user->update([
                    'status' => $request->status,
                    'catatan' => $request->catatan
                ]);
            }

            if($request->status == 'approved') {
                // update status
                $user->update([
                    'status' => $request->status,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Verifikasi Data Kapal'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal verifikasi akun'
            ]);
        }
    }
}