<?php

namespace App\Http\Controllers\Admin\TransaksiNonKas;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule; 


class TransaksiNonKasController extends Controller
{
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);

    $query = Transaksi::with(['sumber', 'tujuan', 'data_user'])
        ->where('type_transaksi', 'TNK');

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_transaksi', [
            $request->start_date,
            $request->end_date
        ]);
    }

    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
    }

    $TransaksiNonKas = $query
        ->orderBy('id_transaksi', 'asc')
        ->paginate($perPage)
        ->appends($request->except('page'));

    return view('admin.transaksi_non_kas.transaksi', compact('TransaksiNonKas'));
}


    public function create()
    {

        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_non_kas.tambah-transaksi', compact('akunSumber','akunTujuan'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('nonkas', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('nonkas', 'Y');
                }),
            ],
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiNonKas = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TNK',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $TransaksiNonKas->kode_transaksi = 'TNK' . $TransaksiNonKas->id_transaksi;
        $TransaksiNonKas->save();

        return redirect()->route('transaksi-non-kas.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $TransaksiNonKas = Transaksi::findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('nonkas','Y')
            ->where('is_kas', 0)
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_non_kas.edit-transaksi', compact('TransaksiNonKas','akunSumber','akunTujuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'id_jenisAkunTransaksi_sumber' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn ($q) => $q->where('nonkas', 'Y')),
        ],
        'id_jenisAkunTransaksi_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(function ($q) {
                    $q->where('nonkas', 'Y');
                }),
            ],
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiNonKas = Transaksi::findOrFail($id);
        $TransaksiNonKas->update([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('transaksi-non-kas.index')->with('success', 'Data Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiNonKas = Transaksi::findOrFail($id);
        $TransaksiNonKas->delete();

        return redirect()->route('transaksi-non-kas.index')->with('success', 'Data Transaksi berhasil dihapus');
    }

    public function download(Request $request)
    {
    $query = \App\Models\Transaksi::query();
    $query->where('kode_transaksi', 'like', 'TNK%');

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