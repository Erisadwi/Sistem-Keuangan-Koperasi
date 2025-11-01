<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {   
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.profil.profilAnggota', compact('anggota'));
    }

        public function edit()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.profil.editProfil', compact('anggota'));
    }

public function update(Request $request, $id)
{
    $anggota = Anggota::findOrFail($id);

    // ✅ 1. Validasi data
    $validated = $request->validate([
        'username_anggota' => 'required|string|max:255',
        'nama_anggota'     => 'required|string|max:255',
        'alamat_anggota'   => 'nullable|string',
        'jabatan'          => 'nullable|string|max:255',
        'password'         => 'nullable|string|min:6',
        'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);

    // ✅ 2. Update field teks biasa
    $anggota->username_anggota = $validated['username_anggota'];
    $anggota->nama_anggota     = $validated['nama_anggota'];
    $anggota->alamat_anggota   = $validated['alamat_anggota'] ?? $anggota->alamat_anggota;
    $anggota->jabatan          = $validated['jabatan'] ?? $anggota->jabatan;

    // ✅ 3. Update password jika diisi
    if (!empty($validated['password'])) {
        $anggota->password = Hash::make($validated['password']);
    }

    // ✅ 4. Update foto jika ada file baru
    if ($request->hasFile('foto')) {
        // hapus foto lama (jika ada)
        if ($anggota->foto && Storage::disk('public')->exists(str_replace('storage/', '', $anggota->foto))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $anggota->foto));
        }

        // simpan foto baru
        $path = $request->file('foto')->store('uploads', 'public');
        $anggota->foto = 'storage/' . $path;
    }

    // ✅ 5. Simpan perubahan
    $anggota->save();

    return redirect()->route('anggota.profil')->with('success', 'Profil berhasil diperbarui!');
}

}