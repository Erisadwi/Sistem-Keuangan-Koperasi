<?php

namespace App\Http\Controllers\Admin\setting;
use App\Http\Controllers\Controller;
use App\Models\identitasKoperasi;
use Illuminate\Http\Request;

class identitasKoperasiController extends Controller
{
    public function edit()
    {
        $identitas_koperasi = identitasKoperasi::firstOrFail();
        return view('admin.setting.identitas-koperasi', compact('identitas_koperasi'));
    }

    public function update(Request $request, $id)
    {   
            $validated = $request->validate([
            'nama_koperasi'        => 'required|string',
            'npwp'                 => 'required|string',
            'alamat_koperasi'      => 'required|string',
            'telepon_koperasi'     => 'required|string',
            'email_koperasi'       => 'required|string',
            'fax_koperasi'         => 'required|string',
            'kode_pos'             => 'required|string',
            'website'              => 'required|string',
            'logo_koperasi'        => 'nullable|string',
            'nama_pimpinan'        => 'required|string',
        ]);

        $identitas_koperasi = identitasKoperasi::firstOrFail();
        $identitas_koperasi->update($validated);


        return redirect()
                ->route('identitas-koperasi.editSingle')
                ->with('success', 'Data berhasil diperbarui');
    }

}
