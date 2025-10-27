<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role']);

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('id_user', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->query('per_page', 10);
        $users = $query->orderBy('id_user', 'asc')->paginate($perPage);

        return view('admin.master_data.data-pengguna', compact('users'));
    }

    public function create()
    {
        $nextId = $this->generateNextId();
        $roles = Role::orderBy('nama_role')->get();

        return view('admin.master_data.tambah-data-pengguna', compact('nextId', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'id_role' => 'required|exists:role,id_role',
            'telepon' => 'nullable|string|max:16',
            'alamat_user' => 'nullable|string|max:255',
            'foto_user' => 'nullable|image|mimes:jpg,jpeg,png|max:5048'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'id_role.required' => 'Role wajib dipilih.',
        ]);

        User::create([
            'id_user' => $this->generateNextId(),
            'nama_lengkap' => $request->nama_lengkap,
            'alamat_user' => $request->alamat_user,
            'telepon' => $request->telepon,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
            'id_role' => $request->id_role,
        ]);

        if ($request->hasFile('foto_user')) {
        $file = $request->file('foto_user');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/foto_user', $filename);
        $data['foto_user'] = $filename;
    }
        return redirect()->route('data-user.index')->with('success', 'Data user berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('nama_role')->get();

        return view('admin.master_data.edit-data-pengguna', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,nonaktif',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'id_role' => 'required|exists:role,id_role',
            'telepon' => 'nullable|string|max:16',
            'alamat_user' => 'nullable|string|max:255',
            'foto_user' => 'nullable|image|mimes:jpg,jpeg,png|max:5048'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'id_role.required' => 'Role wajib dipilih.',
        ]);

        $user = User::findOrFail($id);

        $data = $request->only([
            'nama_lengkap',
            'alamat_user',
            'telepon',
            'username',
            'jenis_kelamin',
            'status',
            'tanggal_masuk',
            'tanggal_keluar',
            'id_role',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_user')) {
        if ($user->foto_user && Storage::exists('public/foto_user/' . $user->foto_user)) {
            Storage::delete('public/foto_user/' . $user->foto_user);
        }

        $file = $request->file('foto_user');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/foto_user', $filename);
        $data['foto_user'] = $filename;
        }

        $user->update($data);

        return redirect()->route('data-user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data-user.index')->with('success', 'Data user berhasil dihapus.');
    }

    private function generateNextId()
    {
        $maxNum = User::selectRaw('MAX(CAST(SUBSTRING(id_user, 3) AS UNSIGNED)) as max_num')
                      ->value('max_num') ?? 0;
        $nextNumber = $maxNum + 1;
        return 'US' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}