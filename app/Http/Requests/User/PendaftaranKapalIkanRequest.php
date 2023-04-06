<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PendaftaranKapalIkanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kode_kapal' => 'required|string',
            'nama_kapal' => 'required|string',
            'nama_pemilik' => 'required|string',
            'alamat_pemilik' => 'required|string',
            'ukuran_kapal' => 'required|int',
            'kapten' => 'required|string',
            'jumlah_anggota' => 'required|int',
            'foto_kapal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dokumen_perizinan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
