<?php

namespace App\Http\Controllers\Admin\TransaksiKas;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class TransaksiPemasukanController extends Controller
{
    public function index(Request $request)
{
    $perPage = 10;

    $query = Transaksi::with(['sumber', 'tujuan', 'data_user'])
        ->where('type_transaksi', 'TKD');

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_transaksi', [
            $request->start_date,
            $request->end_date
        ]);
    }

    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $TransaksiPemasukan = $query
        ->orderBy('id_transaksi', 'asc')
        ->paginate($perPage);

    return view('admin.transaksi_kas.pemasukan', compact('TransaksiPemasukan'));
}


    public function create()
    {
        return view('admin.transaksi_kas.tambah-pemasukan');
    }

    public function store(Request $request) 
    {
        Log::info('➡️ MASUK store TransaksiPemasukanController');
        $request->validate([
            'id_jenisAkunTransaksi_sumber' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPemasukan = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKD',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $TransaksiPemasukan->kode_transaksi = 'TKD' . $TransaksiPemasukan->id_transaksi;
        $TransaksiPemasukan->save();

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $TransaksiPemasukan = Transaksi::findOrFail($id);
        return view('admin.transaksi_kas.edit-pemasukan', compact('TransaksiPemasukan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPemasukan = Transaksi::findOrFail($id);
        $TransaksiPemasukan->update([
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiPemasukan = Transaksi::findOrFail($id);
        $TransaksiPemasukan->delete();

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data Transaksi berhasil dihapus');
    }

    public function download(Request $request)
    {
    $query = \App\Models\Transaksi::query();

    if ($request->has('search')) {
        $query->where('kode_transaksi', 'like', "%{$request->search}%");
    }

    if ($request->has(['start_date', 'end_date'])) {
        $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
    }

    $data = $query->get();

    $html = '<h2>Laporan Transaksi Pemasukan</h2><table border="1" cellspacing="0" cellpadding="5" width="100%">
                <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Untuk Kas</th>
                <th>Dari Akun</th>
                <th>Jumlah</th>
                <th>User</th>
                </tr>';
    foreach ($data as $item) {
        $html .= "<tr>
                    <td>{$item->kode_transaksi}</td>
                    <td>{$item->tanggal_transaksi}</td>
                    <td>{$item->ket_transaksi}</td>
                    <td>{$item->tujuan->nama_AkunTransaksi}</td>
                    <td>{$item->sumber->nama_AkunTransaksi}</td>
                    <td>Rp " . number_format($item->jumlah_transaksi, 0, ',', '.') . "</td>
                    <td>{$item->data_user?->nama_lengkap}</td>
                  </tr>";
    }
    $html .= '</table>';

    $pdf = Pdf::loadHTML($html);
    return $pdf->download('data-pemasukan.pdf');
}
}