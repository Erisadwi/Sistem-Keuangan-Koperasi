<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Angsuran;
use App\Models\Anggota;
use App\Models\ViewDataAngsuran;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;
use App\Services\AngsuranService;

class BayarAngsuranController extends Controller
{
    protected $service;

    public function __construct(AngsuranService $service)
    {
        $this->service = $service;
    }

    public function show($id_pinjaman)
    {

        // 🧩 1️⃣ Ambil pinjaman berdasarkan kode_transaksi
        $pinjaman = Pinjaman::where('id_pinjaman', $id_pinjaman)->first();

        if (!$pinjaman) {
            return back()->with('error', 'Data pinjaman tidak ditemukan.');
        }

        // 🧩 2️⃣ Ambil anggota berdasarkan username dari pinjaman
        $anggota = Anggota::where('username_anggota', $pinjaman->username_anggota)->first();

        // 🧩 3️⃣ Ambil data tambahan dari view (view_data_angsuran)
        $view = ViewDataAngsuran::where('kode_transaksi', $pinjaman->kode_transaksi)->first();

        // 🧩 4️⃣ Ambil semua pembayaran angsuran (riwayat)
        $payments = Angsuran::where('id_pinjaman', $pinjaman->id)
                            ->orderBy('angsuran_ke', 'asc')
                            ->get();

        // 🧩 5️⃣ Hitung total pembayaran, sisa angsuran, sisa tagihan
        $totalBayar = $payments->sum('jumlah');
        $sisaAngsuran = max(0, $pinjaman->lama_pinjaman - $payments->count());
        $sisaTagihan = max(0, $pinjaman->total_pinjaman - $totalBayar);

        // 🧩 6️⃣ Tentukan status pinjaman
        $status = $sisaAngsuran == 0 ? 'Lunas' : 'Belum Lunas';

        // 🧩 7️⃣ Gabungkan semua data ke view
        return view('admin.pinjaman.bayar-angsuran', [
            'pinjaman' => $pinjaman,
            'anggota' => $anggota,
            'view' => $view,
            'payments' => $payments,
            'totalBayar' => $totalBayar,
            'sisaAngsuran' => $sisaAngsuran,
            'sisaTagihan' => $sisaTagihan,
            'status' => $status,
        ]);
    }
}
