<?php

namespace App\Http\Controllers\Admin\Simpanan;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\JenisAkunTransaksi;
use App\Models\JenisSimpanan;
use Illuminate\Http\Request;
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

        return view('admin.simpanan.penarikan-tunai', compact('penarikanTunai', 'toolbar'));
    }

    public function create()
    {
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();
        $jenisSimpanan = JenisSimpanan::all(['id_jenis_simpanan', 'jenis_simpanan', 'jumlah_simpanan']);

        $akunTransaksi = JenisAkunTransaksi::where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.tambah-penarikan-tunai', compact(
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
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi', // kas
            'jumlah_simpanan' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jenisSimpanan = JenisSimpanan::findOrFail($request->id_jenis_simpanan);

        
        $akunSumber = $jenisSimpanan->id_jenisAkunTransaksi; 
        $akunTujuan = $request->id_jenisAkunTransaksi_tujuan; 

        $last = Simpanan::where('type_simpanan', 'TRK')
            ->orderBy('id_simpanan', 'desc')
            ->first();

        $nextCode = 'TRK' . str_pad(($last->id_simpanan ?? 0) + 1, 5, '0', STR_PAD_LEFT);

        Simpanan::create([
            'id_user' => Auth::user()->id_user,
            'id_anggota' => $request->id_anggota,
            'id_jenis_simpanan' => $request->id_jenis_simpanan,

            'id_jenisAkunTransaksi_sumber' => $akunTujuan, 
            'id_jenisAkunTransaksi_tujuan' => $akunSumber,

            'jumlah_simpanan' => $request->jumlah_simpanan,
            'type_simpanan' => 'TRK',
            'kode_simpanan' => $nextCode,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('penarikan-tunai.index')
            ->with('success', 'Penarikan tunai berhasil disimpan.');
    }

    public function edit($id)
    {
        $penarikanTunai = Simpanan::findOrFail($id);
        $anggota = Anggota::where('status_anggota', 'Aktif')->get();
        $jenisSimpanan = JenisSimpanan::all();
        $akunTransaksi = JenisAkunTransaksi::where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.simpanan.edit-penarikan-tunai', compact(
            'penarikanTunai',
            'anggota',
            'jenisSimpanan',
            'akunTransaksi'
        ));
    }

    public function update(Request $request, $id)
    {
        $penarikanTunai = Simpanan::findOrFail($id);

        $request->validate([
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id_jenis_simpanan',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_simpanan' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jenisSimpanan = JenisSimpanan::findOrFail($request->id_jenis_simpanan);

        $akunSumber = $request->id_jenisAkunTransaksi_tujuan; 
        $akunTujuan = $jenisSimpanan->id_jenisAkunTransaksi;

        $penarikanTunai->update([
            'id_jenis_simpanan' => $request->id_jenis_simpanan,
            'id_jenisAkunTransaksi_sumber' => $akunSumber,
            'id_jenisAkunTransaksi_tujuan' => $akunTujuan,
            'jumlah_simpanan' => $request->jumlah_simpanan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('penarikan-tunai.index')
            ->with('success', 'Penarikan tunai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penarikanTunai = Simpanan::findOrFail($id);
        $penarikanTunai->delete();

        return redirect()->route('penarikan-tunai.index')
            ->with('success', '🗑️ Data penarikan tunai berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRK')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.simpanan.penarikan-tunai.pdfPenarikan', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Penarikan_Tunai.pdf');
    }

    public function cetak($id)
    {
        $penarikan = Simpanan::with(['anggota', 'jenisSimpanan', 'sumber', 'user'])
            ->findOrFail($id);

        return view('admin.simpanan.cetak-nota-penarikan-tunai', compact('penarikan'));
    }
}
