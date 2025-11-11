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

    public function update(Request $request)
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
            'logo_koperasi'        => 'nullable|file|mimes:pdf,jpg,png|max:5048',
            'nama_pimpinan'        => 'required|string',
        ]);

        $identitas_koperasi = identitasKoperasi::firstOrFail();

        // update field lain satu per satu
        $identitas_koperasi->nama_koperasi = $validated['nama_koperasi'];
        $identitas_koperasi->npwp = $validated['npwp'];
        $identitas_koperasi->alamat_koperasi = $validated['alamat_koperasi'];
        $identitas_koperasi->telepon_koperasi = $validated['telepon_koperasi'];
        $identitas_koperasi->email_koperasi = $validated['email_koperasi'];
        $identitas_koperasi->fax_koperasi = $validated['fax_koperasi'];
        $identitas_koperasi->kode_pos = $validated['kode_pos'];
        $identitas_koperasi->website = $validated['website'];
        $identitas_koperasi->nama_pimpinan = $validated['nama_pimpinan'];

if ($request->hasFile('logo_koperasi')) {
    $file = $request->file('logo_koperasi');

    if ($file->isValid()) {
        $data = file_get_contents($file->getRealPath());

        // Simpan hanya isi file (binary)
        $identitas_koperasi->logo_koperasi = $data;
    }
}

        $identitas_koperasi->save();


        return redirect()
            ->route('identitas-koperasi.editSingle')
            ->with('success', 'Data berhasil diperbarui');
        }

public function showLogo($nama_koperasi)
{
    $identitas = IdentitasKoperasi::where('nama_koperasi', urldecode($nama_koperasi))->firstOrFail();

    if (!$identitas->logo_koperasi) {
        abort(404, 'Logo tidak ditemukan');
    }

    // Deteksi MIME type dari data binary
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($identitas->logo_koperasi);

    return response($identitas->logo_koperasi)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
}



}
