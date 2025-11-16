<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\SaldoAwalNonKasExport;
use Maatwebsite\Excel\Facades\Excel;

class SaldoAwalNonKasController extends Controller
{
    public function index()
    {
        $saldoAwalNonKas = Transaksi::with(['details.akun', 'data_user'])
            ->where('type_transaksi', 'SANK') 
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('admin.master_data.saldo-awal-non-kas', compact('saldoAwalNonKas'));
    }

    public function create()
    {
        $akunKas = JenisAkunTransaksi::where('status_akun', 'AKTIF')->get();
        return view('admin.master_data.tambah-data-saldo-awal-non-kas', compact('akunKas'));
    }

    public function export()
    {
    return Excel::download(new SaldoAwalNonKasExport, 'saldo-awal-non-kas.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = Transaksi::create([
              //  'id_user' => Auth::check() ? Auth::user()->id_user : null,//
                'type_transaksi' => 'SANK',
                'kode_transaksi' => '',
                'ket_transaksi' => $request->ket_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            $transaksi->kode_transaksi = 'SANK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
            $transaksi->save();

            $transaksi->details()->create([
                'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                'debit' => $request->jumlah_transaksi,
                'kredit' => 0,
            ]);
        });

       return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $saldoAwalNonKas = Transaksi::with('details')->findOrFail($id);
        $detail = $saldoAwalNonKas->details->first();
        $akunKas = JenisAkunTransaksi::where('status_akun', 'AKTIF')->get();
        return view('admin.master_data.edit-data-saldo-awal-non-kas', compact('saldoAwalNonKas' , 'detail', 'akunKas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $id) {
            $transaksi = Transaksi::findOrFail($id);

            $transaksi->update([
                'ket_transaksi' => $request->ket_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            $detail = $transaksi->details()->first();
            if ($detail) {
                $detail->update([
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                    'debit' => $request->jumlah_transaksi,
                    'kredit' => 0,
                ]);
            } else {
                $transaksi->details()->create([
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                    'debit' => $request->jumlah_transaksi,
                    'kredit' => 0,
                ]);
            }
        });

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->details()->delete();
            $transaksi->delete();
        });

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil dihapus.');
    }

}
