<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\AkunRelasiTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\SaldoAwalKasExport;
use Maatwebsite\Excel\Facades\Excel;

class SaldoAwalKasController extends Controller
{
    public function index()
    {
        $saldoAwalKas = Transaksi::with(['details.akun', 'data_user'])
            ->where('type_transaksi', 'SAK')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('admin.master_data.saldo-awal-kas', compact('saldoAwalKas'));
    }

    public function create()
    {
        $akunKas = JenisAkunTransaksi::where('status_akun', 'AKTIF')->get();
        return view('admin.master_data.tambah-data-saldo-awal-kas', compact('akunKas'));
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
                'id_user' => Auth::user()->id_user,
                'type_transaksi' => 'SAK',
                'kode_transaksi' => '',
                'ket_transaksi' => $request->ket_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            $transaksi->kode_transaksi = 'SAK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
            $transaksi->save();

            // Detail transaksi (lama)
            $transaksi->details()->create([
                'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                'debit' => $request->jumlah_transaksi,
                'kredit' => 0,
            ]);

            // Insert ke akun relasi transaksi (baru)
            AkunRelasiTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_akun' => $request->id_jenisAkunTransaksi_tujuan,
                'id_akun_berkaitan' => $request->id_jenisAkunTransaksi_tujuan,
                'debit' => $request->jumlah_transaksi,
                'kredit' => 0,
                'kode_transaksi' => $transaksi->kode_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

        });

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $saldoAwalKas = Transaksi::with('details')->findOrFail($id);
        $detail = $saldoAwalKas->details->first();
        $akunKas = JenisAkunTransaksi::where('status_akun', 'AKTIF')->get();

        return view('admin.master_data.edit-data-saldo-awal-kas', compact('saldoAwalKas', 'detail', 'akunKas'));
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

            // update detail transaksi
            $detail = $transaksi->details()->first();
            if ($detail) {
                $detail->update([
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                    'debit' => $request->jumlah_transaksi,
                    'kredit' => 0,
                ]);
            }

            AkunRelasiTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();
            
            AkunRelasiTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_akun' => $request->id_jenisAkunTransaksi_tujuan,
                'id_akun_berkaitan' => $request->id_jenisAkunTransaksi_tujuan,
                'debit' => $request->jumlah_transaksi,
                'kredit' => 0,
                'kode_transaksi' => $transaksi->kode_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);
           
        });

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);

            AkunRelasiTransaksi::where('id_transaksi', $transaksi->kode_transaksi)->delete();

            $transaksi->details()->delete();
            $transaksi->delete();
        });

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new SaldoAwalKasExport, 'saldo-awal-kas.xlsx');
    }
}
