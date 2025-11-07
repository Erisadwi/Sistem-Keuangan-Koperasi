<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewDataAngsuran; 
use App\Services\AngsuranService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use App\Models\Anggota;
use App\Models\JenisAkunTransaksi;
use Illuminate\Support\Facades\Log;
use App\Models\Angsuran;
use Carbon\Carbon;
use App\Models\Pinjaman;

class AngsuranController extends Controller
{
    protected $service;
    public function __construct(AngsuranService $service)
    {
        $this->middleware('auth:user');
        $this->service = $service;

    }

    public function index(Request $request)
    {
        $query = ViewDataAngsuran::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjaman', [$request->start_date, $request->end_date]);
        }

        if ($request->kode_transaksi) {
            $query->where('kode_transaksi', 'like', '%' . $request->kode_transaksi . '%');
        }

        if ($request->nama_anggota) {
            $query->where('nama_anggota', 'like', '%' . $request->nama_anggota . '%');
        }

        $dataAngsuran = $query->paginate(10);
        return view('admin.pinjaman.angsuran', compact('dataAngsuran'));
    }




    public function bayar($id_pinjaman)
    {
        $angsuran = ViewDataAngsuran::where('id_pinjaman', $id_pinjaman)->firstOrFail();
        $pinjaman = Pinjaman::with('anggota')->where('id_pinjaman', $id_pinjaman)->first();

        if (!$pinjaman) {
            return redirect()->back()->with('error', 'Data pinjaman tidak ditemukan.');
        }

        $anggota = $pinjaman->anggota;

        $view = ViewDataAngsuran::where('id_pinjaman', $id_pinjaman)->first();

        if (!$view) {
            return back()->with('error', 'Data angsuran tidak ditemukan.');
        }


        $payments = Angsuran::where('id_pinjaman', $id_pinjaman)->get();
        foreach ($payments as $pay) {
        $pay->keterlambatan = 0;

        if (!empty($pay->tanggal_jatuh_tempo)) {
            $jatuhTempo = Carbon::parse($pay->tanggal_jatuh_tempo);
            $hariIni = Carbon::now();

            if ($hariIni->gt($jatuhTempo)) {
                $pay->keterlambatan = $hariIni->diffInDays($jatuhTempo);
            }
        }
    }
        $denda = 0;
        $keterlambatan = 0;

        $angsuranTerakhir = Angsuran::where('id_pinjaman', $id_pinjaman)
            ->orderByDesc('tanggal_jatuh_tempo')
            ->first();

        if ($angsuranTerakhir && $angsuranTerakhir->tanggal_jatuh_tempo) {
            $jatuhTempo = Carbon::parse($angsuranTerakhir->tanggal_jatuh_tempo);
            $hariIni = Carbon::now();

            if ($hariIni->gt($jatuhTempo)) {
                $keterlambatan = $hariIni->diffInDays($jatuhTempo);
            }
        }

        $totalBayar = $payments->sum(function ($pay) {
        return ($pay->angsuran_pokok ?? 0) + ($pay->bunga_angsuran ?? 0) + ($pay->denda ?? 0);});
        $totalPeriode = $pinjaman->lamaAngsuran->lama_angsuran ?? 0;

        $jumlahAngsuranDibayar = $payments->count();

        $sisaAngsuran = max(0, $totalPeriode - $jumlahAngsuranDibayar);
        $sisaTagihan = max(0, $pinjaman->total_tagihan - $totalBayar);

        $status = $sisaAngsuran == 0 ? 'Lunas' : 'Belum Lunas';

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

        return view('admin.pinjaman.bayar-angsuran', [
            'pinjaman' => $pinjaman,
            'anggota' => $anggota,
            'view' => $view,
            'payments' => $payments,
            'totalBayar' => $totalBayar,
            'sisaAngsuran' => $sisaAngsuran,
            'sisaTagihan' => $sisaTagihan,
            'status' => $status,
            'denda' => $denda,
            'tanggalTempo' => $tanggalTempo,
            'keterlambatan' => $keterlambatan,
        ]);
    }

        public function create($id_pinjaman)
    {
        $pinjaman = Pinjaman::with(['anggota', 'lamaAngsuran'])->findOrFail($id_pinjaman);
        $payments = Angsuran::where('id_pinjaman', $id_pinjaman)->get();

        $totalBayar = $payments->sum(function ($pay) {
        return ($pay->angsuran_pokok ?? 0) + ($pay->bunga_angsuran ?? 0) + ($pay->denda ?? 0);});
        $totalPeriode = $pinjaman->lamaAngsuran->lama_angsuran ?? 0;

        $jumlahAngsuranDibayar = $payments->count();

        $sisaAngsuran = max(0, $totalPeriode - $jumlahAngsuranDibayar);
        $sisaTagihan = max(0, $pinjaman->total_tagihan - $totalBayar);


        $angsuranKe = $payments->count() + 1;
        $angsuranPokok = $pinjaman->jumlah_pinjaman / $pinjaman->lamaAngsuran->lama_angsuran;
        $bungaAngsuran = $pinjaman->bunga_pinjaman / $pinjaman->lamaAngsuran->lama_angsuran;
        $angsuranPerBulan = $angsuranPokok + $bungaAngsuran;

        $tanggalPinjaman = Carbon::parse($pinjaman->tanggal_pinjaman);
        $tanggalJatuhTempo = $tanggalPinjaman->copy()->addMonthsNoOverflow($angsuranKe)->day(30);


        $denda = 0;

        $idBayar = Angsuran::generateId();

        $akunSumber = JenisAkunTransaksi::where('angsuran','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('angsuran','Y')
            ->where('is_kas', 1)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.pinjaman.tambah-bayar-angsuran', compact(
            'pinjaman', 'payments', 'sisaTagihan', 'sisaAngsuran', 'angsuranKe', 
            'angsuranPerBulan', 'angsuranPokok', 'bungaAngsuran', 'denda', 'idBayar', 'akunSumber', 'akunTujuan'
        ));
    }


    public function store(Request $request, $id_pinjaman)
    {

        $request->validate([
            'tanggal_bayar' => 'required|date',
            'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('angsuran', 'Y');
                    $q->where('is_kas', 0);
                }),
            ],
            'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('angsuran', 'Y');
                    $q->where('is_kas', 1);
                }),
            ],
        ]);

        $pinjaman = Pinjaman::with('lamaAngsuran')->findOrFail($id_pinjaman);
        $payments = Angsuran::where('id_pinjaman', $id_pinjaman)->get();

        $angsuranKe = $payments->count() + 1;
        $tanggalPinjaman = Carbon::parse($pinjaman->tanggal_pinjaman);
        $tanggalJatuhTempo = $tanggalPinjaman->copy()->addMonthsNoOverflow($angsuranKe)->day(30);

        Log::info('Sebelum create');
        Angsuran::create([
            'id_bayar_angsuran' => Angsuran::generateId(),
            'id_pinjaman' => $id_pinjaman,
            'tanggal_bayar' => $request->tanggal_bayar,
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'angsuran_ke' => $request->angsuran_ke,
            'angsuran_per_bulan' => $request->angsuran_per_bulan,
            'angsuran_pokok' => $request->angsuran_pokok,
            'bunga_angsuran' => $request->bunga_angsuran,
            'sisa_tagihan' => $request->sisa_tagihan,
            'denda' => $request->denda ?? 0,
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'keterangan' => $request->keterangan,
            'id_user' => Auth::user()->id_user,
        ]);
        Log::info('Setelah create', ['id' => $angsuran->id ?? null]);

        return redirect()->route('bayar.angsuran', ['id_pinjaman' => $id_pinjaman])
        ->with('success', 'Angsuran berhasil ditambahkan.');

    }

}
