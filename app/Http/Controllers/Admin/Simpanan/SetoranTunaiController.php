<?php

namespace App\Http\Controllers\Admin\Simpanan;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\JenisAkunTransaksi;
use App\Models\JenisSimpanan;
use Illuminate\Http\Request;
use App\Models\AkunRelasiTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SetoranTunaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRD');

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->startOfDay();
            $end   = \Carbon\Carbon::parse($request->end)->endOfDay();
            $query->whereBetween('tanggal_transaksi', [$start, $end]);
        
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        if ($request->filled('kode')) {
            $query->where('kode_simpanan', 'like', '%' . $request->kode . '%');
        }

        if ($request->filled('nama')) {
            $query->whereHas('anggota', function ($q) use ($request) {
                $q->where('nama_anggota', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('jenis')) {
            $query->whereHas('jenisSimpanan', function ($q) use ($request) {
                $q->where('jenis_simpanan', $request->jenis);
            });
        }

        $setoranTunai = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        if ($setoranTunai->isEmpty() && $request->hasAny(['start','end','tanggal','kode','nama','jenis'])) {
            session()->flash('warning', '⚠️ Tidak ditemukan data dengan filter yang diterapkan.');
        }

        $toolbar = [
            'addUrl'    => route('setoran-tunai.create'),
            'editUrl'   => route('setoran-tunai.edit', '__ID__'),
            'deleteUrl' => route('setoran-tunai.destroy', '__ID__'),
            'exportUrl' => route('setoran-tunai.exportPdf'),
        ];

        return view('admin.simpanan.setoran-tunai.setoran-tunai', compact('setoranTunai', 'toolbar'));
    }


    public function create()
    {
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();

        $jenisSimpanan = JenisSimpanan::where('tampil_simpanan', 'Y')
            ->get(['id_jenis_simpanan', 'jenis_simpanan', 'jumlah_simpanan']);

        $akunKas = JenisAkunTransaksi::where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.setoran-tunai.tambah-setoran-tunai', compact(
            'anggota',
            'jenisSimpanan',
            'akunKas'
        ));
    }

   public function store(Request $request)
   {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id_jenis_simpanan',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_simpanan' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'bukti_setoran' => 'nullable|file|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $buktiPath = $request->hasFile('bukti_setoran')
                ? $request->file('bukti_setoran')->store('bukti_setoran', 'public')
                : null;

            $jenisSimpanan = JenisSimpanan::findOrFail($request->id_jenis_simpanan);
            $akunSumber = $jenisSimpanan->id_jenisAkunTransaksi;
            $akunTujuan = $request->id_jenisAkunTransaksi_tujuan;

            // Kode TRD anti duplikat
            $nextCode = 'TRD' . str_pad(Simpanan::where('type_simpanan', 'TRD')->count() + 1, 5, '0', STR_PAD_LEFT);

            $simpanan = Simpanan::create([
                'id_user' => Auth::user()->id_user,
                'id_anggota' => $request->id_anggota,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'id_jenisAkunTransaksi_sumber' => $akunSumber,
                'id_jenisAkunTransaksi_tujuan' => $akunTujuan,
                'jumlah_simpanan' => $request->jumlah_simpanan,
                'type_simpanan' => 'TRD',
                'kode_simpanan' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'keterangan' => $request->keterangan,
                'bukti_setoran' => $buktiPath
            ]);

            // jurnal debit
            AkunRelasiTransaksi::create([
                'id_transaksi' => $simpanan->id_simpanan,
                'id_akun' => $akunTujuan,
                'id_akun_berkaitan' => $akunSumber,
                'debit' => $request->jumlah_simpanan,
                'kredit' => 0,
                'kode_transaksi' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            // jurnal kredit
            AkunRelasiTransaksi::create([
                'id_transaksi' => $simpanan->id_simpanan,
                'id_akun' => $akunSumber,
                'id_akun_berkaitan' => $akunTujuan,
                'debit' => 0,
                'kredit' => $request->jumlah_simpanan,
                'kode_transaksi' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            DB::commit();
            return redirect()->route('setoran-tunai.index')->with('success', 'Data setoran tunai berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $setoranTunai = Simpanan::findOrFail($id);
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();
        $jenisSimpanan = JenisSimpanan::all();

        $akunKas = JenisAkunTransaksi::where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.setoran-tunai.edit-setoran-tunai', compact(
            'setoranTunai',
            'anggota',
            'jenisSimpanan',
            'akunKas'
        ));
    }


    public function update(Request $request, $id)
    {
        $setoran = Simpanan::findOrFail($id);

        $request->validate([
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id_jenis_simpanan',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_simpanan' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti_setoran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $jenisSimpanan = JenisSimpanan::findOrFail($request->id_jenis_simpanan);
            $akunSumber = $jenisSimpanan->id_jenisAkunTransaksi;
            $akunTujuan = $request->id_jenisAkunTransaksi_tujuan;

            $data = $request->only(['id_jenis_simpanan', 'jumlah_simpanan', 'tanggal_transaksi', 'keterangan']);
            $data['id_jenisAkunTransaksi_sumber'] = $akunSumber;
            $data['id_jenisAkunTransaksi_tujuan'] = $akunTujuan;

            if ($request->hasFile('bukti_setoran')) {
                $data['bukti_setoran'] = $request->file('bukti_setoran')
                    ->store('bukti_setoran', 'public');
            }

            $setoran->update($data);

            // Hapus jurnal lama
            AkunRelasiTransaksi::where('id_transaksi', $id)->delete();

            // Buat jurnal baru
            AkunRelasiTransaksi::create([
                'id_transaksi' => $id,
                'id_akun' => $akunTujuan,
                'id_akun_berkaitan' => $akunSumber,
                'debit' => $request->jumlah_simpanan,
                'kredit' => 0,
                'kode_transaksi' => $setoran->kode_simpanan,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            AkunRelasiTransaksi::create([
                'id_transaksi' => $id,
                'id_akun' => $akunSumber,
                'id_akun_berkaitan' => $akunTujuan,
                'debit' => 0,
                'kredit' => $request->jumlah_simpanan,
                'kode_transaksi' => $setoran->kode_simpanan,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            DB::commit();
            return redirect()->route('setoran-tunai.index')->with('success', 'Data setoran tunai berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $setoran = Simpanan::findOrFail($id);

            AkunRelasiTransaksi::where('id_transaksi', $id)->delete();

            if ($setoran->bukti_setoran) {
                Storage::disk('public')->delete($setoran->bukti_setoran);
            }

            $setoran->delete();

            DB::commit();
            return redirect()->route('setoran-tunai.index')->with('success', 'Data setoran tunai berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function exportPdf()
    {
        $data = Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRD')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.simpanan.setoran-tunai.setoran-tunai-export-pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Setoran_Tunai.pdf');
    }


    public function cetak($id)
    {
        $setoran = Simpanan::with(['anggota', 'jenisSimpanan', 'tujuan', 'user'])
            ->findOrFail($id);

        return view('admin.simpanan.setoran-tunai.cetak-nota-setoran-tunai', compact('setoran'));
    }
}

