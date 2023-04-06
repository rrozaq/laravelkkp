<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class KapalIkanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_kapal' => $this->nama_kapal,
            'nama_pemilik' => $this->nama_pemilik,
            'alamat_pemilik' => $this->alamat_pemilik,
            'ukuran_kapal' => $this->ukuran_kapal,
            'kapten' => $this->kapten,
            'jumlah_anggota' => $this->jumlah_anggota,
            'foto_kapal' => $this->foto_kapal ? App::make('url')->to('/') . '/kapal_ikan/foto_kapal/' . $this->foto_kapal : NULL,
            'nomor_izin' => $this->nomor_izin,
            'dokumen_perizinan' => $this->dokumen_perizinan ? App::make('url')->to('/') . '/kapal_ikan/dokumen_perizinan/' . $this->dokumen_perizinan : NULL,
            'status' => $this->status,
            'user' => [
                'id' => $this->user->id,
                'nama' => $this->user->nama,
            ],
        ];
    }
}
