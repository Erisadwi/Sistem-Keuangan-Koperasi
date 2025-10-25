<?php

namespace App\Http\Controllers\Admin\setting;
use App\Http\Controllers\Controller;
use App\Models\identitasKoperasi;
use Illuminate\Http\Request;

class identitasKoperasiController extends Controller
{
    public function editSingle()
    {
        $identitas_koperasi = identitasKoperasi::firstOrFail();
        return view('admin.setting.identitas-koperasi', compact('identitas_koperasi'));
    }

    public function update(Request $request, $id)
    {   
            $validated = $request->validate([
            'nama_koperasi'        => 'required|string',
            'npwp'                 => 'nullable|string',
            'alamat_koperasi'      => 'required|numeric',
            'telepon_koperasi'     => 'nullable|string',
            'email_koperasi'       => 'nullable|string',
            'fax_koperasi'         => 'nullable|string',
            'kode_pos'             => 'nullable|string',
            'website'              => 'nullable|string',
            'logo_koperasi'        => 'nullable|string',
            'nama_pimpinan'        => 'nullable|string',
        ]);

        $identitas_koperasi = identitasKoperasi::firstOrFail();
        identitasKoperasi::update($validated);

        return redirect()
                ->route('identitas-koperasi.edit')
                ->with('success', 'Data berhasil diperbarui');
    }

}
