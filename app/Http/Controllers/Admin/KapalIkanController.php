<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KapalIkan;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\KapalIkanResource;

class KapalIkanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin','permission:verifikasi-kapal|delete-kapal']);
    }

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

    public function delete($id)
    {
        try {
            // get kapalIkan by id
            $kapalIkan = KapalIkan::where('id', $id)->first();

            // delete kapalIkan
            $kapalIkan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus data kapal ikan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data kapal ikan'
            ]);
        }
    }
}