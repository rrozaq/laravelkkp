<?php

namespace App\Http\Controllers;

use App\Models\KapalIkan;
use Illuminate\Http\Request;

class DataKapalController extends Controller
{
    public function getDataKapal()
    {
        $kapalIkan = KapalIkan::all()->makeHidden(['dokumen_perizinan']);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data kapal ikan',
            'data' => $kapalIkan
        ]);
    }
}
