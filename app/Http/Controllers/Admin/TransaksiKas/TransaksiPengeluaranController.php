<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use App\Models\JenisAkunTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
            ->where('type_transaksi', 'TKK'); 

        if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = $request->start_date . ' 00:00:00';
        $endDate   = $request->end_date . ' 23:59:59';
        $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiPengeluaran = $query
            ->orderBy('id_transaksi', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.pengeluaran.pengeluaran', compact('TransaksiPengeluaran'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.pengeluaran.tambah-pengeluaran',compact('akunSumber','akunTujuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 1)), 
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 0)), 
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
        ]);

        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $TransaksiPengeluaran = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKK',
            'kode_transaksi' => '',
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $TransaksiPengeluaran->kode_transaksi = 'TKK' . str_pad($TransaksiPengeluaran->id_transaksi, 5, '0', STR_PAD_LEFT);
        $TransaksiPengeluaran->save();

         foreach ($request->sumber as $s) {
           DetailTransaksi::create([
            'id_transaksi' => $TransaksiPengeluaran->id_transaksi,
            'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
            'debit' => $s['jumlah'], 
            'kredit' => 0,

            ]);
        }

        DetailTransaksi::create([
            'id_transaksi' => $TransaksiPengeluaran->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
            'debit' => 0,
            'kredit' => $total,
        ]);
        
        return redirect()->route('pengeluaran.index')
            ->with('success', 'Transaksi Pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
{
    $TransaksiPengeluaran = Transaksi::with('details.akun')->findOrFail($id);

    $akunSumber = JenisAkunTransaksi::where('pengeluaran','Y')
        ->where('is_kas', 0)
        ->where('status_akun', 'Y')
        ->orderBy('nama_AkunTransaksi')
        ->get();

    $akunTujuan = JenisAkunTransaksi::where('pengeluaran','Y')
        ->where('is_kas', 1)
        ->where('status_akun', 'Y')
        ->orderBy('nama_AkunTransaksi')
        ->get();

  
   $akun_tujuan = $TransaksiPengeluaran->details->where('kredit', '>', 0)->first(); 

   $akun_sumber = $TransaksiPengeluaran->details->where('debit', '>', 0); 

    return view('admin.transaksi_kas.pengeluaran.edit-pengeluaran', compact(
        'TransaksiPengeluaran',
        'akunSumber',
        'akunTujuan',
        'akun_tujuan',
        'akun_sumber'
    ));
}


   public function update(Request $request, $id)
    {
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('is_kas', 1)),
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('is_kas', 0)),
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
    ]);

    $TransaksiPengeluaran = Transaksi::findOrFail($id);

    $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

    $TransaksiPengeluaran->update([
        'tanggal_transaksi' => $request->tanggal_transaksi,
        'ket_transaksi' => $request->ket_transaksi,
        'total_debit' => $total,
        'total_kredit' => $total,
    ]);

    $TransaksiPengeluaran->details()->delete();

    foreach ($request->sumber as $s) {
        DetailTransaksi::create([
            'id_transaksi' => $TransaksiPengeluaran->id_transaksi,
            'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
            'debit' => $s['jumlah'],
            'kredit' => 0,
        ]);
    }

    DetailTransaksi::create([
        'id_transaksi' => $TransaksiPengeluaran->id_transaksi,
        'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
        'debit' => 0,
        'kredit' => $total,
    ]);

    return redirect()->route('pengeluaran.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiPengeluaran = Transaksi::findOrFail($id);
        $TransaksiPengeluaran->details()->delete();
        $TransaksiPengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data berhasil dihapus');
    }

   public function exportPdf(Request $request)
    {
    
    $year = now()->year;

    $startDate = "$year-01-01 00:00:00";
    $endDate   = "$year-12-31 23:59:59";

    $data = Transaksi::with(['details.akun', 'data_user'])
        ->where('type_transaksi', 'TKK')
        ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
        ->orderBy('id_transaksi', 'desc')
        ->get();

    $pdf = Pdf::loadView('admin.transaksi_kas.pengeluaran.pengeluaran-export-pdf', [
        'data' => $data,
        'startDate' => $startDate,
        'endDate' => $endDate
    ])->setPaper('A4', 'portrait');

    return $pdf->download("transaksi_pengeluaran_kas_$year.pdf");
    }


}
