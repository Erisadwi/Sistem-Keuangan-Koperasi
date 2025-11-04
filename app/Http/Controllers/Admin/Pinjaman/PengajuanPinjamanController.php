<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AjuanPinjaman;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;

class PengajuanPinjamanController extends Controller
{

    public function index()
    {
        $ajuanPinjaman = AjuanPinjaman::with(['anggota', 'lama_angsuran'])
            ->where('status_ajuan', '!=', 'Ditolak')
            ->get();

        return view('admin.pinjaman.data-pengajuan', compact('ajuanPinjaman'));
    }


    public function disetujui($id)
    {   
        $ajuanPinjaman = AjuanPinjaman::with('anggota', 'lama_angsuran')->findOrFail($id);
        $ajuanPinjaman = AjuanPinjaman::findOrFail($id);
        $ajuanPinjaman->status_ajuan = 'Disetujui';
        $ajuanPinjaman->save();

        $biayaAdmin = BiayaAdministrasi::first(); // sesuaikan query jika ada tipe pinjaman tertentu

        $bunga = ($biayaAdmin->bunga / 100) * $ajuanPinjaman->jumlah_ajuan;
        $biaya_admin = ($biayaAdmin->biaya_admin / 100) * $ajuanPinjaman->jumlah_ajuan;

        Pinjaman::create([
        'id_pinjaman' => Pinjaman::generateId(),
        'id_ajuanPinjaman' => $ajuanPinjaman->id_ajuanPinjaman,
        'id_user' => Auth::user()->id_user ?? null, 
        'id_anggota' => $ajuanPinjaman->id_anggota,
        'id_lamaAngsuran' => $ajuanPinjaman->id_lamaAngsuran ?? null,
        'tanggal_pinjaman' => now(),
        'bunga_pinjaman' => $bunga,
        'jumlah_pinjaman' => $ajuanPinjaman->jumlah_ajuan,
        'total_tagihan' => $ajuanPinjaman->jumlah_ajuan + $bunga + $biaya_admin, 
        'keterangan' => $ajuanPinjaman->keterangan ?? '-',
        'status_lunas' => 'BELUM LUNAS', 
        'biaya_admin' => $biaya_admin,
        'id_jenisAkunTransaksi_tujuan' => $ajuanPinjaman->id_jenisAkunTransaksi_tujuan ?? null,
        'id_jenisAkunTransaksi_sumber' => $ajuanPinjaman->id_jenisAkunTransaksi_sumber ?? null
    ]);

        return redirect()->route('pengajuan-pinjaman.index')
        ->with('success', 'Pengajuan pinjaman disetujui.');
    }

    public function tolak($id)
    {
        $ajuanPinjamanPinjaman = AjuanPinjaman::findOrFail($id);
        $ajuanPinjamanPinjaman->status_ajuan = 'Ditolak';
        $ajuanPinjamanPinjaman->save();

        return redirect()->route('pengajuan-pinjaman.index')->with('success', 'Pengajuan pinjaman ditolak.');
    }

    

}
