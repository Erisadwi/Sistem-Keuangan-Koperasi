<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\AkunRelasiTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.master_data.tambah-data-saldo-awal-non-kas', compact('akunSumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',

            'id_jenisAkunTransaksi_sumber' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('nonkas', 'Y')
                                        ->where('status_akun', 'Y')
                                        ->where('is_kas', 0))
            ],
        ]);

        $transaksi = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'SANK',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        $transaksi->kode_transaksi = 'SANK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
        $transaksi->save();

        $akunSumber = JenisAkunTransaksi::find($request->id_jenisAkunTransaksi_sumber);

        $debit = 0;
        $kredit = 0;

        if ($akunSumber->type_akun === 'ACTIVA') {
            $debit = $request->jumlah_transaksi;
        } else {
            $kredit = $request->jumlah_transaksi;
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_sumber,
            'debit' => $debit,
            'kredit' => $kredit,
        ]);

        $akunBerkaitan = JenisAkunTransaksi::where('kode_aktiva', 'MODALAWAL')->first();

        AkunRelasiTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_akun' => $request->id_jenisAkunTransaksi_sumber,
            'id_akun_berkaitan' => $request->id_jenisAkunTransaksi_sumber,
            'debit' => $debit,
            'kredit' => $kredit,
            'kode_transaksi' => $transaksi->kode_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $saldoAwalNonKas = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $detail = $saldoAwalNonKas->details->first();

        return view('admin.master_data.edit-data-saldo-awal-non-kas', compact('saldoAwalNonKas', 'akunSumber', 'detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',

            'id_jenisAkunTransaksi_sumber' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('nonkas', 'Y')
                                        ->where('status_akun', 'Y')
                                        ->where('is_kas', 0))
            ],
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        $transaksi->details()->delete();
        AkunRelasiTransaksi::where('id_transaksi', $id)->delete();

        $akunSumber = JenisAkunTransaksi::find($request->id_jenisAkunTransaksi_sumber);

        $debit = 0;
        $kredit = 0;

        if ($akunSumber->type_akun === 'ACTIVA') {
            $debit = $request->jumlah_transaksi;
        } else {
            $kredit = $request->jumlah_transaksi;
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_sumber,
            'debit' => $debit,
            'kredit' => $kredit,
        ]);

        $akunBerkaitan = JenisAkunTransaksi::where('kode_aktiva', 'MODALAWAL')->first();

        AkunRelasiTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_akun' => $request->id_jenisAkunTransaksi_sumber,
            'id_akun_berkaitan' => $request->id_jenisAkunTransaksi_sumber,
            'debit' => $debit,
            'kredit' => $kredit,
            'kode_transaksi' => $transaksi->kode_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete();
        AkunRelasiTransaksi::where('id_transaksi', $id)->delete();
        $transaksi->delete();

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new SaldoAwalNonKasExport, 'saldo-awal-non-kas.xlsx');
    }
}
