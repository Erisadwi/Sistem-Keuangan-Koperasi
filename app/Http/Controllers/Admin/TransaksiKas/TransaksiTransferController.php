<?php

namespace App\Http\Controllers\Admin\TransaksiKas;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; 
use Barryvdh\DomPDF\Facade\Pdf;


class TransaksiTransferController extends Controller
{
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);

    $query = Transaksi::with(['sumber', 'tujuan', 'data_user'])
        ->where('type_transaksi', 'TRF');

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_transaksi', [
            $request->start_date,
            $request->end_date
        ]);
    }

    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $TransaksiTransfer = $query
        ->orderBy('id_transaksi', 'desc')
        ->paginate($perPage)
        ->appends($request->except('page'));

    return view('admin.transaksi_kas.transfer', compact('TransaksiTransfer'));
}


    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.tambah-transfer',compact('akunSumber','akunTujuan'));
    }

    public function store(Request $request) 
    {
        Log::info('➡️ MASUK store TransaksiTransferController');
        $request->validate(rules: [
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('transfer', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('transfer', 'Y');
                    $q->where('is_kas', 1);
                }),TRF
            ],
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiTransfer = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TRF',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $TransaksiTransfer->kode_transaksi = 'TRF' . $TransaksiTransfer->id_transaksi;
        $TransaksiTransfer->save();

        return redirect()->route('transaksi-transfer.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {

        $TransaksiTransfer = Transaksi::findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.edit-transfer', compact('TransaksiTransfer','akunSumber','akunTujuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('transfer', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('transfer', 'Y');
                    $q->where('is_kas', 1);
                }),
            ],
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiTransfer = Transaksi::findOrFail($id);
        $TransaksiTransfer->update([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('transaksi-transfer.index')->with('success', 'Data Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiTransfer = Transaksi::findOrFail($id);
        $TransaksiTransfer->delete();

        return redirect()->route('transaksi-transfer.index')->with('success', 'Data Transaksi berhasil dihapus');
    }

    public function download(Request $request)
    {
    $query = \App\Models\Transaksi::query();
    $query->where('kode_transaksi', 'like', 'TRF%');

    if ($request->has('search')) {
        $query->where('kode_transaksi', 'like', "%{$request->search}%");
    }

    if ($request->has(['start_date', 'end_date'])) {
        $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
    }

    $data = $query->get();

    $html = '<h2>Laporan Transaksi Transfer</h2><table border="1" cellspacing="0" cellpadding="5" width="100%">
                <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Dari Kas</th>
                <th>Untuk Kas</th>
                <th>User</th>
                </tr>';
    foreach ($data as $item) {
        $html .= "<tr>
                    <td>{$item->kode_transaksi}</td>
                    <td>{$item->tanggal_transaksi}</td>
                    <td>{$item->ket_transaksi}</td>
                    <td>Rp " . number_format($item->jumlah_transaksi, 0, ',', '.') . "</td>
                    <td>{$item->sumber->nama_AkunTransaksi}</td>
                    <td>{$item->tujuan->nama_AkunTransaksi}</td>
                    <td>{$item->data_user?->nama_lengkap}</td>
                  </tr>";
    }
    $html .= '</table>';

    $pdf = Pdf::loadHTML($html);
    return $pdf->download('data-transfer.pdf');
}
}