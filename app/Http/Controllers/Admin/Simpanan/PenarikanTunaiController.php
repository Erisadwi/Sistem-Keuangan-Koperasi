<?php

namespace App\Http\Controllers\Admin\Simpanan;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\JenisAkunTransaksi;
use App\Models\JenisSimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AkunRelasiTransaksi;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PenarikanTunaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRK');

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->startOfDay();
            $end = \Carbon\Carbon::parse($request->end)->endOfDay();
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

        $penarikanTunai = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        if ($penarikanTunai->isEmpty() && $request->hasAny(['start', 'end', 'tanggal', 'kode', 'nama', 'jenis'])) {
            session()->flash('warning', '⚠️ Tidak ditemukan data dengan filter yang diterapkan.');
        }

        $toolbar = [
            'addUrl'    => route('penarikan-tunai.create'),
            'editUrl'   => route('penarikan-tunai.edit', '__ID__'),
            'deleteUrl' => route('penarikan-tunai.destroy', '__ID__'),
            'exportUrl' => route('penarikan-tunai.exportPdf'),
        ];

        return view('admin.simpanan.penarikan-tunai.penarikan-tunai', compact('penarikanTunai', 'toolbar'));
    }

    public function create()
    {
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();
        $jenisSimpanan = JenisSimpanan::all(['id_jenis_simpanan', 'jenis_simpanan', 'jumlah_simpanan']);

        $akunTransaksi = JenisAkunTransaksi::where('penarikan', 'Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.penarikan-tunai.tambah-penarikan-tunai', compact(
            'anggota',
            'jenisSimpanan',
            'akunTransaksi'
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
            'keterangan' => 'nullable|string|max:255',
            'bukti_setoran' => 'nullable|file|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $buktiPath = $request->hasFile('bukti_setoran')
                ? $request->file('bukti_setoran')->store('bukti_setoran', 'public')
                : null;

            $jenisSimpanan = JenisSimpanan::findOrFail($request->id_jenis_simpanan);
            $akunSumber = $jenisSimpanan->id_jenisAkunTransaksi; // akun simpanan
            $akunTujuan = $request->id_jenisAkunTransaksi_tujuan; // akun kas

            $nextCode = 'TRK' . str_pad(Simpanan::where('type_simpanan', 'TRK')->count() + 1, 5, '0', STR_PAD_LEFT);

            $penarikan = Simpanan::create([
                'id_user' => Auth::user()->id_user,
                'id_anggota' => $request->id_anggota,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'id_jenisAkunTransaksi_sumber' => $akunSumber,
                'id_jenisAkunTransaksi_tujuan' => $akunTujuan,
                'jumlah_simpanan' => $request->jumlah_simpanan,
                'type_simpanan' => 'TRK',
                'kode_simpanan' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'keterangan' => $request->keterangan,
                'bukti_setoran' => $buktiPath
            ]);

            // jurnal debit (kas keluar)
            AkunRelasiTransaksi::create([
                'id_transaksi' => $penarikan->id_simpanan,
                'id_akun' => $akunTujuan,
                'id_akun_berkaitan' => $akunSumber,
                'debit' => 0,
                'kredit' => $request->jumlah_simpanan,
                'kode_transaksi' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            // jurnal kredit (simpanan berkurang)
            AkunRelasiTransaksi::create([
                'id_transaksi' => $penarikan->id_simpanan,
                'id_akun' => $akunSumber,
                'id_akun_berkaitan' => $akunTujuan,
                'debit' => $request->jumlah_simpanan,
                'kredit' => 0,
                'kode_transaksi' => $nextCode,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            DB::commit();
            return redirect()->route('penarikan-tunai.index')->with('success', 'Penarikan tunai berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $penarikanTunai = Simpanan::findOrFail($id);
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();
        $jenisSimpanan = JenisSimpanan::all();
        $akunTransaksi = JenisAkunTransaksi::where('penarikan', 'Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.penarikan-tunai.edit-penarikan-tunai', compact(
            'penarikanTunai',
            'anggota',
            'jenisSimpanan',
            'akunTransaksi'
        ));
    }

    public function update(Request $request, $id)
    {
        $penarikan = Simpanan::findOrFail($id);

        $request->validate([
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id_jenis_simpanan',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_simpanan' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti_setoran' => 'nullable|file|max:2048',
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
                $data['bukti_setoran'] = $request->file('bukti_setoran')->store('bukti_setoran', 'public');
            }

            $penarikan->update($data);

            // hapus jurnal lama
            AkunRelasiTransaksi::where('id_transaksi', $id)->delete();

            // jurnal debit / kredit baru
            AkunRelasiTransaksi::create([
                'id_transaksi' => $id,
                'id_akun' => $akunTujuan,
                'id_akun_berkaitan' => $akunSumber,
                'debit' => 0,
                'kredit' => $request->jumlah_simpanan,
                'kode_transaksi' => $penarikan->kode_simpanan,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            AkunRelasiTransaksi::create([
                'id_transaksi' => $id,
                'id_akun' => $akunSumber,
                'id_akun_berkaitan' => $akunTujuan,
                'debit' => $request->jumlah_simpanan,
                'kredit' => 0,
                'kode_transaksi' => $penarikan->kode_simpanan,
                'tanggal_transaksi' => $request->tanggal_transaksi
            ]);

            DB::commit();
            return redirect()->route('penarikan-tunai.index')->with('success', 'Penarikan tunai berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

   public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $penarikan = Simpanan::findOrFail($id);

            AkunRelasiTransaksi::where('id_transaksi', $id)->delete();

            if ($penarikan->bukti_setoran) {
                Storage::disk('public')->delete($penarikan->bukti_setoran);
            }

            $penarikan->delete();
            DB::commit();
            return redirect()->route('penarikan-tunai.index')->with('success', 'Penarikan tunai berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function exportPdf()
    {
        $data = Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRK')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.simpanan.penarikan-tunai.penarikan-tunai-export-pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Penarikan_Tunai.pdf');
    }

    public function cetak($id)
    {
        $penarikan = Simpanan::with(['anggota', 'jenisSimpanan', 'sumber', 'user'])
            ->findOrFail($id);

        return view('admin.simpanan.penarikan-tunai.cetak-nota-penarikan-tunai', compact('penarikan'));
    }
}
