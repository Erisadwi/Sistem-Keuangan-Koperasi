<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index(Request $request)
    {   
        $user = Auth::guard('user')->user();
        return view('admin.profil.beranda-profil', compact('user'));
    }

        public function edit()
    {
        $user = Auth::guard('user')->user();
        return view('admin.profil.edit-profil', compact('user'));
    }

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'nama_lengkap'     => 'required|string|max:255',
        'alamat_user'   => 'nullable|string',
        'role'          => 'nullable|string|max:255',
        'password'         => 'nullable|string|min:6',
        'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);

    $user->username = $validated['username'];
    $user->nama_lengkap     = $validated['nama_lengkap'];
    $user->alamat_user   = $validated['alamat_user'] ?? $user->alamat_user;
    $user->id_role = $validated['role'] ?? $user->id_role;

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    if ($request->hasFile('foto')) {

        if ($user->foto && Storage::disk('public')->exists(str_replace('storage/', '', $user->foto))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $user->foto));
        }

        $path = $request->file('foto')->store('uploads', 'public');
        $user->foto = 'storage/' . $path;
    }

    $user->save();

    return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
}

}