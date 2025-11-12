<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel; 

class AnggotaController extends Controller
{
    public function index(Request $request)
    {   
    $perPage = (int) $request->query('per_page', 10);
    $search = $request->input('search'); 

    $query = Anggota::query();

    if (!empty($search)) {
        $query->where('nama_anggota', 'like', '%' . $search . '%')
              ->orWhere('id_anggota', 'like', '%' . $search . '%')
              ->orWhere('username_anggota', 'like', '%' . $search . '%');
    }

    $anggota = $query->orderBy('id_anggota', 'asc')->paginate($perPage);

    if ($search) {
        $anggota->appends(['search' => $search]);
    }

    return view('admin.master_data.data-anggota', compact('anggota', 'search'));
    }


    public function create()
    {
        return view('admin.master_data.tambah-data-anggota', [
            'anggota' => null
        ]);
    }

    public function export()
    {
    return Excel::download(new AnggotaExport, 'data_anggota.xlsx');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username_anggota'   => 'required|string',
            'password_anggota'   => 'required|string',
            'nama_anggota'       => 'required|string',
            'jenis_kelamin'      => 'required|in:L,P',
            'alamat_anggota'     => 'required|string',
            'kota_anggota'       => 'required|string',
            'tempat_lahir'       => 'required|string',
            'tanggal_lahir'      => 'required|date_format:Y-m-d',
            'departemen'         => 'nullable|in:PRODUKSI BOPP,PRODUKSI SLITTING,WH,QA,HRD,GA,PURCHASING,ACCOUNTING,ENGINEERING',
            'pekerjaan'          => 'nullable|in:TNI,PNS,KARYAWAN SWASTA,GURU,BURUH,TANI,PEDAGANG,WIRASWASTA,MENGURUS RUMAH TANGGA,LAINNYA',
            'jabatan'            => 'required|in:KETUA,SEKRETARIS,BENDAHARA,PENGAWAS,KARYAWAN,PERUSAHAAN',
            'agama'              => 'nullable|in:ISLAM,KATOLIK,PROTESTAN,HINDU,BUDHA,LAINNYA',
            'status_perkawinan'  => 'nullable|in:BELUM KAWIN,KAWIN,CERAI HIDUP,CERAI MATI,LAINNYA',
            'tanggal_registrasi' => 'required|date_format:Y-m-d',
            'tanggal_keluar'     => 'nullable|date_format:Y-m-d',
            'no_telepon'         => 'nullable|string|max:20',
            'status_anggota'     => 'required|in:AKTIF,NON AKTIF',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        if ($request->hasFile('foto')) {

        $validated['foto'] = 'storage/' . $request->file('foto')->store('uploads', 'public');
        }

        $validated['id_anggota'] = Anggota::generateId();
        $validated['password_anggota'] = Hash::make($validated['password_anggota']);

        unset($validated['kode_anggota']);
        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
    $anggota = Anggota::findOrFail($id);
    return view('admin.master_data.edit-data-anggota', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
    $anggota = Anggota::findOrFail($id);

    $validated = $request->validate([
        'username_anggota'   => 'required|string',
        'password_anggota'   => 'nullable|string', 
        'nama_anggota'       => 'required|string',
        'jenis_kelamin'      => 'required|in:L,P',
        'alamat_anggota'     => 'required|string',
        'kota_anggota'       => 'required|string',
        'tempat_lahir'       => 'required|string',
        'tanggal_lahir'      => 'required|date_format:Y-m-d',
        'departemen'         => 'nullable|in:PRODUKSI BOPP,PRODUKSI SLITTING,WH,QA,HRD,GA,PURCHASING,ACCOUNTING,ENGINEERING',
        'pekerjaan'          => 'nullable|in:TNI,PNS,KARYAWAN SWASTA,GURU,BURUH,TANI,PEDAGANG,WIRASWASTA,MENGURUS RUMAH TANGGA,LAINNYA',
        'jabatan'            => 'required|in:KETUA,SEKRETARIS,BENDAHARA,PENGAWAS,KARYAWAN,PERUSAHAAN',
        'agama'              => 'nullable|in:ISLAM,KATOLIK,PROTESTAN,HINDU,BUDHA,LAINNYA',
        'status_perkawinan'  => 'nullable|in:BELUM KAWIN,KAWIN,CERAI HIDUP,CERAI MATI,LAINNYA',
        'tanggal_registrasi' => 'required|date_format:Y-m-d',
        'tanggal_keluar'     => 'nullable|date_format:Y-m-d',
        'no_telepon'         => 'nullable|string|max:20',
        'status_anggota'     => 'required|in:AKTIF,NON AKTIF',
        'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);


    if ($request->hasFile('foto')) {
        if ($anggota->foto && Storage::disk('public')->exists(str_replace('storage/', '', $anggota->foto))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $anggota->foto));
        }

        $validated['foto'] = 'storage/' . $request->file('foto')->store('uploads', 'public');
    }

    if (!empty($validated['password_anggota'])) {
        $validated['password_anggota'] = Hash::make($validated['password_anggota']);
    } else {
        unset($validated['password_anggota']); 
    }

    $anggota->update($validated);

    return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        if ($anggota->foto && Storage::disk('public')->exists(str_replace('storage/', '', $anggota->foto))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $anggota->foto));
        }

        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}
