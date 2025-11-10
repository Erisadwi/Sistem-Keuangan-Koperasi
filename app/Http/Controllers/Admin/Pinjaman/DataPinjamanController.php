<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Models\AjuanPinjaman;
use App\Models\User;
use App\Models\SukuBunga;
use App\Models\Anggota;
use App\Models\LamaAngsuran;
use App\Models\JenisAkunTransaksi;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DataPinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::with(['ajuanPinjaman', 'user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'])->get();

        foreach ($pinjaman as $item) {
            $jumlah = $item->jumlah_pinjaman ?? 0;
            $lama   = $item->lamaAngsuran->lama_angsuran ?? 0;

            $item->pokok_angsuran = $lama > 0 ? round($jumlah / $lama, 2) : 0;
            $item->lama_angsuran_text = $lama > 0 ? $lama . ' Bulan' : '-';

            $bunga = $item->bunga_pinjaman ?? 0;
            $item->jumlah_angsuran_otomatis = $item->pokok_angsuran + $bunga;

            $totalBayar = Angsuran::where('id_pinjaman', $item->id_pinjaman)
                ->sum(\DB::raw('(angsuran_pokok + bunga_angsuran + denda)'));

            $totalAngsuranDibayar = Angsuran::where('id_pinjaman', $item->id_pinjaman)->count();

            $item->sudah_dibayar = $totalBayar;
            $item->sisa_tagihan = max(($item->total_tagihan ?? 0) - $totalBayar, 0);
            $item->sisa_angsuran = max(0, $lama - $totalAngsuranDibayar);

            if ($item->status_lunas === 'LUNAS') {
                $item->sudah_dibayar = $item->total_tagihan;
                $item->sisa_tagihan = 0;
                $item->sisa_angsuran = 0;
            }
        }

        return view('admin.pinjaman.data-pinjaman', compact('pinjaman'));
    }

    public function create()
    {
        $ajuanPinjaman = AjuanPinjaman::all();
        $users = User::all();
        $anggota = Anggota::all();
        $lamaAngsuran = LamaAngsuran::all();
        $akunTransaksi = JenisAkunTransaksi::all();

        return view('admin.pinjaman.tambah-data-pinjaman', compact(
            'ajuanPinjaman', 'users', 'anggota', 'lamaAngsuran', 'akunTransaksi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_jenisAkunTransaksi_sumber' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_lamaAngsuran' => 'required|exists:lama_angsuran,id_lamaAngsuran',
            'tanggal_pinjaman' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:0',
        ]);

        $jumlah = $request->jumlah_pinjaman;

        $sukuBunga = SukuBunga::firstOrFail();
        $ratePinjaman = (float) $sukuBunga->suku_bunga_pinjaman;
        $rateAdmin = (float) $sukuBunga->biaya_administrasi;

        $lamaAngsuran = LamaAngsuran::findOrFail($request->id_lamaAngsuran);
        $lama = (int) $lamaAngsuran->lama_angsuran;

        $bunga_pinjaman = $lama > 0
            ? round((($ratePinjaman / 100) * $jumlah) / $lama, 2)
            : 0;

        $biaya_admin = round(($rateAdmin / 100) * $jumlah, 2);
        $totalTagihan = $jumlah + ($bunga_pinjaman * $lama);

        $idPinjaman = Pinjaman::generateId();

        Pinjaman::create([
            'id_pinjaman' => $idPinjaman,
            'id_user' => Auth::user()->id_user,
            'id_anggota' => $request->id_anggota,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_lamaAngsuran' => $request->id_lamaAngsuran,
            'tanggal_pinjaman' => $request->tanggal_pinjaman,
            'bunga_pinjaman' => $bunga_pinjaman,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'total_tagihan' => $totalTagihan,
            'biaya_admin' => $biaya_admin,
            'status_lunas' => 'BELUM LUNAS',
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil disimpan!');
    }

    public function show($id)
{
    $pinjaman = Pinjaman::with(['anggota', 'lamaAngsuran', 'angsuran'])->findOrFail($id);
    $anggota = $pinjaman->anggota;

    $lama = $pinjaman->lamaAngsuran->lama_angsuran ?? 0;
    $pokok = $pinjaman->jumlah_pinjaman ?? 0;
    $bunga = $pinjaman->bunga_pinjaman ?? 0;
    $biaya_admin = $pinjaman->biaya_admin ?? 0;

    $pokokPerBulan = $lama > 0 ? round($pokok / $lama, 0) : 0;
    $angsuranPerBulan = $pokokPerBulan + $bunga + $biaya_admin;

    $tanggalTempo = null;

        if (!empty($pinjaman->tanggal_pinjaman) && $pinjaman->lamaAngsuran) {

            $tanggalPinjaman = $pinjaman->tanggal_pinjaman instanceof Carbon
                                ? $pinjaman->tanggal_pinjaman
                                : Carbon::parse($pinjaman->tanggal_pinjaman);

            $lamaAngsuran = max(1, (int) $pinjaman->lamaAngsuran->lama_angsuran);

            $tanggalTempoObj = $tanggalPinjaman->copy()->addMonthsNoOverflow($lamaAngsuran);
            $tanggalTempoObj->day(min(30, $tanggalTempoObj->daysInMonth));

            $tanggalTempo = $tanggalTempoObj->toDateString();
        }

    $payments = collect();
    for ($i = 1; $i <= $lama; $i++) {
        $payments->push((object)[
            'bulan_ke' => $i,
            'angsuran_pokok' => $pokokPerBulan,
            'angsuran_bunga' => $bunga,
            'biaya_admin' => $biaya_admin,
            'jumlah_angsuran' => $angsuranPerBulan,
           'tanggalTempo' => $tanggalTempo,
        ]);
    }

    $bayar_angsuran = $pinjaman->angsuran()->orderBy('tanggal_bayar', 'asc')->get();

    $totalBayar = $bayar_angsuran->sum('angsuran_per_bulan');
    $totalDenda = $bayar_angsuran->sum('denda');
    $totalPokok = $bayar_angsuran->sum('angsuran_pokok');
    $totalBunga = $bayar_angsuran->sum('bunga_angsuran');

    $totalTagihan = $angsuranPerBulan * $lama;
    $sisaTagihan = max(0, $totalTagihan - $totalBayar);

    $pinjaman->sisa_angsuran = $lama - $bayar_angsuran->count();
    $pinjaman->sudah_dibayar = $totalBayar;
    $pinjaman->denda = $totalDenda;
    $pinjaman->sisa_tagihan = $sisaTagihan;
    $pinjaman->status = $pinjaman->sisa_angsuran <= 0 ? 'LUNAS' : 'BELUM LUNAS';

    return view('admin.pinjaman.detail-peminjaman', compact(
    'pinjaman',
    'anggota',
    'payments',
    'bayar_angsuran',
    'tanggalTempo',
    'lama',
    'totalBayar',
    'totalDenda',
    'sisaTagihan'
));
}

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus!');
    }

    public function cetakNota($id)
    {
        $pinjaman = Pinjaman::with(['anggota', 'lamaAngsuran'])->findOrFail($id);

        $pokok_pinjaman = $pinjaman->jumlah_pinjaman;
        $lama = $pinjaman->lamaAngsuran->lama_angsuran ?? 0;
        $angsuran_pokok = $lama > 0 ? $pokok_pinjaman / $lama : 0;
        $angsuran_bunga = $pinjaman->bunga_pinjaman ?? 0;
        $jumlah_angsuran = $angsuran_pokok + $angsuran_bunga;

        return view('admin.pinjaman.cetak-nota-dataPinjaman', compact(
            'pinjaman',
            'pokok_pinjaman',
            'angsuran_pokok',
            'angsuran_bunga',
            'jumlah_angsuran'
        ));
    }
}
