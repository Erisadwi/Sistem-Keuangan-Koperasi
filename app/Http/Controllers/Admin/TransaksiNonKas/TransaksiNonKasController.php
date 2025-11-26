<?php

namespace App\Http\Controllers\Admin\TransaksiNonKas;

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

class TransaksiNonKasController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
            ->where('type_transaksi', 'TNK');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiNonKas = $query->orderBy('id_transaksi', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_non_kas.transaksi', compact('TransaksiNonKas'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_non_kas.tambah-transaksi', compact('akunSumber', 'akunTujuan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('nonkas', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 0)), 
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('nonkas', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 0)), 
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
    ]);


        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TNK',
            'kode_transaksi' => '',
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->kode_transaksi = 'TNK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
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

        return redirect()->route('transaksi-non-kas.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $TransaksiNonKas = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akun_tujuan = $TransaksiNonKas->details->firstWhere('debit', '>', 0);
        $akun_sumber = $TransaksiNonKas->details->where('kredit', '>', 0)->values();

        return view('admin.transaksi_non_kas.edit-transaksi', compact('TransaksiNonKas', 'akunSumber', 'akunTujuan', 'akun_tujuan', 'akun_sumber'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string|max:255',
            'id_akun_tujuan' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('nonkas', 'Y')
                                        ->where('is_kas', 0)), 
            ],
            'sumber' => 'required|array|min:1',
            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('nonkas', 'Y')
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

        return redirect()->route('transaksi-non-kas.index')->with('success', 'Transaksi berhasil diperbarui.');
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

            return redirect()->route('transaksi-non-kas.index')
                ->with('success', 'Data berhasil dihapus');
        });
    }

   public function exportPdf(Request $request)
{
    $query = Transaksi::with(['details.akun', 'data_user'])
        ->where('type_transaksi', 'TNK');

    // === Jika user memberi filter ===
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate   = $request->end_date . ' 23:59:59';
    } else {
        // === Jika user tidak memberi filter ===
        $tahun = date('Y');
        $startDate = $tahun . '-01-01 00:00:00';
        $endDate   = $tahun . '-12-31 23:59:59';
    }

    $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);

    // === Search kode transaksi ===
    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $data = $query->orderBy('id_transaksi', 'desc')->get();

    return Pdf::loadView('admin.transaksi_non_kas.nonkas-export-pdf', [
        'data' => $data,
        'periodStart' => $startDate,
        'periodEnd'   => $endDate,
    ])
    ->setPaper('A4', 'landscape')
    ->download('laporan_transaksi_non_kas.pdf');
}

}
