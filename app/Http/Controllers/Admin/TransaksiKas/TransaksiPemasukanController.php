<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\AkunRelasiTransaksi;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiPemasukanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
            ->where('type_transaksi', 'TKD');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [
                $request->start_date, 
                $request->end_date
            ]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiPemasukan = $query->orderBy('id_transaksi', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.pemasukan.pemasukan', compact('TransaksiPemasukan'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.pemasukan.tambah-pemasukan', compact('akunSumber', 'akunTujuan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pemasukan', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 1)), 
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pemasukan', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 0)), 
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
    ]);


        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKD',
            'kode_transaksi' => '',
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->kode_transaksi = 'TKD' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
        $transaksi->save();

        foreach ($request->sumber as $s) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                'debit' => 0,
                'kredit' => $s['jumlah'],
            ]);
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
            'debit' => $total,
            'kredit' => 0,
        ]);

        // ========== INSERT KE TABEL akun_relasi_transaksi ==========
        $idTransaksi = $transaksi->id_transaksi;
        $kode = $transaksi->kode_transaksi;
        $tanggal = $transaksi->tanggal_transaksi;

        // Akun tujuan (KAS) → DEBIT, 1 baris untuk setiap sumber
        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $request->id_akun_tujuan,
                'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                'debit' => $s['jumlah'],
                'kredit' => 0,
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }

        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $s['id_jenisAkunTransaksi'],
                'id_akun_berkaitan' => $request->id_akun_tujuan,
                'debit' => 0,
                'kredit' => $s['jumlah'],
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }



        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $TransaksiPemasukan = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akun_tujuan = $TransaksiPemasukan->details->firstWhere('debit', '>', 0);
        $akun_sumber = $TransaksiPemasukan->details->where('kredit', '>', 0)->values();

        return view('admin.transaksi_kas.pemasukan.edit-pemasukan', compact('TransaksiPemasukan', 'akunSumber', 'akunTujuan', 'akun_tujuan', 'akun_sumber'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string|max:255',
            'id_akun_tujuan' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('pemasukan', 'Y')
                                        ->where('is_kas', 1)), 
            ],
            'sumber' => 'required|array|min:1',
            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('pemasukan', 'Y')
                                        ->where('is_kas', 0)), 
            ],
            'sumber.*.jumlah' => 'required|numeric|min:1',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->details()->delete();
        // Hapus relasi lama
        AkunRelasiTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();


        foreach ($request->sumber as $s) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                'debit' => 0,
                'kredit' => $s['jumlah'],
            ]);
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
            'debit' => $total,
            'kredit' => 0,
        ]);

        // ========== INSERT KE TABEL akun_relasi_transaksi ==========
        $idTransaksi = $transaksi->id_transaksi;
        $kode = $transaksi->kode_transaksi;
        $tanggal = $transaksi->tanggal_transaksi;

        // Akun tujuan (KAS) → DEBIT, 1 baris untuk setiap sumber
        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $request->id_akun_tujuan,
                'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                'debit' => $s['jumlah'],
                'kredit' => 0,
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }


        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $s['id_jenisAkunTransaksi'],
                'id_akun_berkaitan' => $request->id_akun_tujuan,
                'debit' => 0,
                'kredit' => $s['jumlah'],
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }


        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $t = Transaksi::findOrFail($id);

            DetailTransaksi::where('id_transaksi', $id)->delete();

            if (class_exists(\App\Models\AkunRelasiTransaksi::class)) {
                \App\Models\AkunRelasiTransaksi::where('id_transaksi', $id)->delete();
            }

            $t->delete();

            return redirect()->route('transaksi-pemasukan.index')
                ->with('success', 'Data berhasil dihapus');
        });
    }


public function exportPdf(Request $request)
{
    $query = Transaksi::with(['details.akun', 'data_user'])
        ->where('type_transaksi', 'TKD');

    // === Tentukan Periode
    if ($request->filled('start_date') && $request->filled('end_date')) {

        $periodStart = $request->start_date . ' 00:00:00';
        $periodEnd   = $request->end_date . ' 23:59:59';

        $query->whereBetween('tanggal_transaksi', [$periodStart, $periodEnd]);

    } else {

        $tahun = date('Y');

        $periodStart = $tahun . '-01-01 00:00:00';
        $periodEnd   = $tahun . '-12-31 23:59:59';

        $query->whereBetween('tanggal_transaksi', [$periodStart, $periodEnd]);
    }

    // === Filter search ===
    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $data = $query->orderBy('id_transaksi', 'desc')->get();

    return Pdf::loadView('admin.transaksi_kas.pemasukan.pemasukan-export-pdf', [
        'data'        => $data,
        'periodStart' => $periodStart,
        'periodEnd'   => $periodEnd,
    ])->setPaper('A4', 'landscape')
      ->download('transaksi_pemasukan_kas.pdf');
}

}
