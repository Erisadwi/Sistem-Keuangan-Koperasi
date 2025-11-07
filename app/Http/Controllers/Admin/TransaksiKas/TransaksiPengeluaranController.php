<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
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

        $query = Transaksi::with(['sumber', 'tujuan', 'data_user'])
            ->where('type_transaksi', 'TKK'); 

        if ($request->filled('start_date') && $request->filled('end_date')) {
        $startDate = date('Y-m-d 00:00:00', strtotime($request->start_date));
        $endDate   = date('Y-m-d 23:59:59', strtotime($request->end_date));

        $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }


        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiPengeluaran = $query
            ->orderBy('id_transaksi', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.pengeluaran', compact('TransaksiPengeluaran'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 1)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.tambah-pengeluaran',compact('akunSumber','akunTujuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('pengeluaran', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('pengeluaran', 'Y');
                    $q->where('is_kas', 1);
                }),
            ],

            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPengeluaran = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKK', 
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $TransaksiPengeluaran->kode_transaksi = 'TKK' . str_pad($TransaksiPengeluaran->id_transaksi, 5, '0', STR_PAD_LEFT);
        $TransaksiPengeluaran->save();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Transaksi Pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $TransaksiPengeluaran = Transaksi::findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pengeluaran','Y')
            ->where('is_kas', 1)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.edit-pengeluaran', compact('TransaksiPengeluaran','akunSumber','akunTujuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('pengeluaran', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('pengeluaran', 'Y');
                    $q->where('is_kas', 1);
                }),
            ],
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPengeluaran = Transaksi::findOrFail($id);
        $TransaksiPengeluaran->update([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiPengeluaran = Transaksi::findOrFail($id);
        $TransaksiPengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {

    $query = Transaksi::with(['sumber', 'tujuan', 'data_user'])
        ->where('type_transaksi', 'TKK'); 

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
    }

    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $data = $query->orderBy('id_transaksi', 'desc')->get();

    $pdf = Pdf::loadView('admin.transaksi_kas.pengeluaran-export-pdf', [
        'data' => $data
    ])->setPaper('A4', 'portrait');

    return $pdf->download('transaksi_pengeluaran_kas.pdf');
    }

}
