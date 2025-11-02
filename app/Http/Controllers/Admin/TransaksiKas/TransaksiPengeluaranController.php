<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiPengeluaranController extends Controller
{
    /**
     * Tampilkan daftar transaksi pengeluaran
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['akunSumber', 'akunTujuan'])
            ->where('type_transaksi', 'TKK')
            ->orderBy('tanggal_transaksi', 'desc');

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        // Pencarian berdasarkan kode transaksi
        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        $TransaksiPengeluaran = $query->paginate(10);

        return view('admin.transaksi_kas.pengeluaran.index', compact('TransaksiPengeluaran'));
    }

    /**
     * Form tambah pengeluaran
     */
    public function create()
    {
        $akun = JenisAkunTransaksi::where('pengeluaran', 'Y')
            ->where('status_akun', 'Y')
            ->get();

        return view('admin.transaksi_kas.pengeluaran.create', compact('akun'));
    }

    /**
     * Simpan transaksi pengeluaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksi,kode_transaksi',
            'tanggal_transaksi' => 'required|date',
            'id_jenisAkunTransaksi_sumber' => 'required',
            'id_jenisAkunTransaksi_tujuan' => 'required|different:id_jenisAkunTransaksi_sumber',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'kode_transaksi' => $request->kode_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
                'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
                'id_user' => Auth::id(),
                'type_transaksi' => 'TKK',
                'jumlah_transaksi' => $request->jumlah_transaksi,
                'ket_transaksi' => $request->ket_transaksi,
            ]);

            // Catat detail debit & kredit (double-entry)
            DetailTransaksi::insert([
                [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_sumber,
                    'kredit' => $request->jumlah_transaksi,
                    'debit' => 0,
                ],
                [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                    'kredit' => 0,
                    'debit' => $request->jumlah_transaksi,
                ],
            ]);

            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Transaksi pengeluaran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit pengeluaran
     */
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $akun = JenisAkunTransaksi::where('status_akun', 'Y')->get();

        return view('admin.transaksi_kas.pengeluaran.edit', compact('transaksi', 'akun'));
    }

    /**
     * Update data pengeluaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'id_jenisAkunTransaksi_sumber' => 'required',
            'id_jenisAkunTransaksi_tujuan' => 'required|different:id_jenisAkunTransaksi_sumber',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->update([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
                'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
                'jumlah_transaksi' => $request->jumlah_transaksi,
                'ket_transaksi' => $request->ket_transaksi,
            ]);

            // Hapus detail lama dan buat baru
            DetailTransaksi::where('id_transaksi', $id)->delete();

            DetailTransaksi::insert([
                [
                    'id_transaksi' => $id,
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_sumber,
                    'kredit' => $request->jumlah_transaksi,
                    'debit' => 0,
                ],
                [
                    'id_transaksi' => $id,
                    'id_jenisAkunTransaksi' => $request->id_jenisAkunTransaksi_tujuan,
                    'kredit' => 0,
                    'debit' => $request->jumlah_transaksi,
                ],
            ]);

            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Data transaksi pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus transaksi pengeluaran
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DetailTransaksi::where('id_transaksi', $id)->delete();
            Transaksi::findOrFail($id)->delete();

            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Data transaksi pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
