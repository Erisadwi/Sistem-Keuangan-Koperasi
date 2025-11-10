<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewDataAngsuran;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PinjamanLunasController extends Controller
{
    public function index(Request $request)
    {
        $query = ViewDataAngsuran::where('status_lunas', 'LUNAS');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjaman', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('nama_anggota')) {
            $query->where('nama_anggota', 'like', '%' . $request->nama_anggota . '%');
        }

        if ($request->filled('kode_transaksi')) {
            $query->where('kode_transaksi', 'like', '%' . $request->kode_transaksi . '%');
        }

        $dataPinjamanLunas = $query->orderBy('tanggal_pinjaman', 'desc')->paginate(10);

        return view('admin.pinjaman.pinjaman-lunas', compact('dataPinjamanLunas'));
    }

    public function detail(Request $request, $kode_transaksi)
    {
        $view = DB::table('view_data_angsuran')
            ->where('kode_transaksi', $kode_transaksi)
            ->first();

        if (!$view) {
            return back()->with('error', 'Data pinjaman tidak ditemukan.');
        }

        $id_pinjaman = $view->id_pinjaman;

        $pinjaman = Pinjaman::with(['anggota', 'lamaAngsuran'])
            ->where('id_pinjaman', $id_pinjaman)
            ->first();

        if (!$pinjaman) {
            return back()->with('error', 'Data pinjaman tidak ditemukan.');
        }

        $anggota = $pinjaman->anggota;

        $paymentsQuery = \App\Models\Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman);

        $isFiltered = false;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $paymentsQuery->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
            $isFiltered = true;
        }

        if ($request->filled('kode_transaksi')) {
            $paymentsQuery->where('id_bayar_angsuran', 'like', '%' . $request->kode_transaksi . '%');
            $isFiltered = true;
        }

        if ($isFiltered) {
            $payments = $paymentsQuery->orderBy('tanggal_bayar', 'asc')->get();
        } else {
            // Jika tidak ada filter, ambil **angsuran terakhir saja**
            $payments = $paymentsQuery->orderByDesc('tanggal_bayar')->limit(1)->get();
        }

        $allPayments = \App\Models\Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)->get();

        $angsuranTerakhir = $allPayments->sortByDesc('tanggal_bayar')->first();

        $totalBayar = $allPayments->sum(function ($pay) {
            return ($pay->angsuran_pokok ?? 0) + ($pay->bunga_angsuran ?? 0) + ($pay->denda ?? 0);
        });

        $totalDenda = $allPayments->sum('denda');
        $sisaTagihan = max(0, ($pinjaman->total_tagihan ?? 0) - $totalBayar);
        $statusPelunasan = $pinjaman->status_lunas ?? 'BELUM LUNAS';
        $tanggalTempo = $view->tanggal_jatuh_tempo ?? null;

        return view('admin.pinjaman.detail-pelunasan', [
            'view' => $view,
            'pinjaman' => $pinjaman,
            'anggota' => $anggota,
            'payments' => $payments,
            'totalBayar' => $totalBayar,
            'totalDenda' => $totalDenda,
            'sisaTagihan' => $sisaTagihan,
            'statusPelunasan' => $statusPelunasan,
            'tanggalTempo' => $tanggalTempo,
            'angsuranTerakhir' => $angsuranTerakhir,
        ]);
    }

    public function cetakNota($id_bayar_angsuran)
    {
        $payment = Angsuran::with(['pinjaman.anggota'])->findOrFail($id_bayar_angsuran);

        $pinjaman = $payment->pinjaman;
        $anggota = $pinjaman->anggota;

        $allPayments = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)->get();
        $totalBayar = $allPayments->sum(function ($p) {
            return ($p->angsuran_pokok ?? 0) + ($p->bunga_angsuran ?? 0) + ($p->denda ?? 0);
        });
        $totalDenda = $allPayments->sum('denda');
        $sisaTagihan = max(0, ($pinjaman->total_tagihan ?? 0) - $totalBayar);
        $statusPelunasan = $pinjaman->status_lunas ?? 'BELUM LUNAS';

        $view = DB::table('view_data_angsuran')
            ->where('id_pinjaman', $pinjaman->id_pinjaman)
            ->first();

        return view('admin.pinjaman.nota-detail-pelunasan', compact(
            'payment', 'pinjaman', 'anggota', 'totalBayar', 'totalDenda', 'sisaTagihan', 'statusPelunasan', 'view'
        ));
    }

}
