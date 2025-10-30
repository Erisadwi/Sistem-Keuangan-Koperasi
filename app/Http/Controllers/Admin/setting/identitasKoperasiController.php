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

    if ($request->hasFile('logo_koperasi')) {
        $file = $request->file('logo_koperasi');
        $data = file_get_contents($file); // ambil konten biner
        $identitas_koperasi->nama_file = $file->getClientOriginalName();
        $identitas_koperasi->logo_koperasi = $data;
    }

    // update field lain
    $identitas_koperasi->update($validated);

    return redirect()
        ->route('identitas-koperasi.editSingle')
        ->with('success', 'Data berhasil diperbarui');
    }

public function showLogo($nama_koperasi)
{
    $identitas_koperasi = identitasKoperasi::where('nama_koperasi', $nama_koperasi)->firstOrFail();

    $extension = pathinfo($identitas_koperasi->nama_file, PATHINFO_EXTENSION);
    $mimeType = match(strtolower($extension)) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        default => 'application/octet-stream',
    };

    return response($identitas_koperasi->logo_koperasi)
           ->header('Content-Type', $mimeType);
}
public function testBlob()
{
    // Ambil record pertama
    $identitas_koperasi = identitasKoperasi::firstOrFail();

    // Tipe konten manual, sesuaikan file yang ada
    $mimeType = 'image/png'; // ganti jika file png/gif/pdf

    return response($identitas_koperasi->logo_koperasi)
           ->header('Content-Type', $mimeType);
}

}
