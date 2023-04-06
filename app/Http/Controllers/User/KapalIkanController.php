<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PendaftaranKapalIkanRequest;
use App\Http\Requests\User\UpdateKapalIkanRequest;
use App\Models\KapalIkan;

class KapalIkanController extends Controller
{
    public function store(PendaftaranKapalIkanRequest $request)
    {
        try {
            $registration = $request->validated();
            $request['user_id'] = auth()->user()->id;
            $registration['user_id'] = auth('api')->user()->id;

            // upload foto kapal
            $file_foto_kapal = $request->file('foto_kapal');
            $foto_kapal = time() . '.' . $file_foto_kapal->getClientOriginalExtension();
            $file_foto_kapal->move(public_path('kapal_ikan/foto_kapal'), $foto_kapal);
            $registration['foto_kapal'] = $foto_kapal;

            // upload dokumen perizinan
            $file_dokumen_perizinan = $request->file('dokumen_perizinan');
            $dokumen_perizinan = time() . '.' . $file_dokumen_perizinan->getClientOriginalExtension();
            $file_dokumen_perizinan->move(public_path('kapal_ikan/dokumen_perizinan'), $dokumen_perizinan);
            $registration['dokumen_perizinan'] = $dokumen_perizinan;

            // store data
            KapalIkan::create($registration);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mendaftarkan kapal ikan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mendaftarkan kapal ikan'
            ]);
        }
    }

    public function update(UpdateKapalIkanRequest $request, $id)
    {
            $registration = $request->validated();
            $request['user_id'] = auth()->user()->id;
            $registration['user_id'] = auth('api')->user()->id;
            
            $kapalIkan = KapalIkan::find($id);

            if($request->hasFile('foto_kapal')) {
                // upload foto kapal
                $file_foto_kapal = $request->file('foto_kapal');
                $foto_kapal = time() . '.' . $file_foto_kapal->getClientOriginalExtension();
                $file_foto_kapal->move(public_path('kapal_ikan/foto_kapal'), $foto_kapal);
                $registration['foto_kapal'] = $foto_kapal;
            } else {
                $registration['foto_kapal'] = $kapalIkan->foto_kapal;
            }

            if($request->hasFile('dokumen_perizinan')) {
                // upload dokumen perizinan
                $file_dokumen_perizinan = $request->file('dokumen_perizinan');
                $dokumen_perizinan = time() . '.' . $file_dokumen_perizinan->getClientOriginalExtension();
                $file_dokumen_perizinan->move(public_path('kapal_ikan/dokumen_perizinan'), $dokumen_perizinan);
                $registration['dokumen_perizinan'] = $dokumen_perizinan;
            } else {
                $registration['dokumen_perizinan'] = $kapalIkan->dokumen_perizinan;
            }

        KapalIkan::where('id', $id)
            ->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengupdate kapal ikan'
        ]);
    }

    public function delete($id)
    {
        KapalIkan::where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus kapal ikan'
        ]);
    }
}