<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiPemasukanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
            ->where('type_transaksi', 'TKD');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiPemasukan = $query->orderBy('id_transaksi', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.pemasukan', compact('TransaksiPemasukan'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.tambah-pemasukan', compact('akunSumber', 'akunTujuan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 1)), 
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 0)), 
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
    ]);


        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKD',
            'kode_transaksi' => '',
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->kode_transaksi = 'TKD' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
        $transaksi->save();

        foreach ($request->sumber as $s) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                'debit' => 0,
                'kredit' => $s['jumlah'],
            ]);
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
            'debit' => $total,
            'kredit' => 0,
        ]);

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $TransaksiPemasukan = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('pemasukan','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akun_tujuan = $TransaksiPemasukan->details->firstWhere('debit', '>', 0);
        $akun_sumber = $TransaksiPemasukan->details->where('kredit', '>', 0)->values();

        return view('admin.transaksi_kas.edit-pemasukan', compact('TransaksiPemasukan', 'akunSumber', 'akunTujuan', 'akun_tujuan', 'akun_sumber'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string|max:255',
            'id_akun_tujuan' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                        ->where('is_kas', 1)), 
            ],
            'sumber' => 'required|array|min:1',
            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                        ->where('is_kas', 0)), 
            ],
            'sumber.*.jumlah' => 'required|numeric|min:1',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->details()->delete();

        foreach ($request->sumber as $s) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                'debit' => 0,
                'kredit' => $s['jumlah'],
            ]);
        }

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
            'debit' => $total,
            'kredit' => 0,
        ]);

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    // Download laporan PDF
    public function download(Request $request)
    {
        $query = Transaksi::with(['details.akun', 'data_user'])->where('type_transaksi', 'TKD');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $data = $query->get();

        $html = '<h2>Laporan Transaksi Kas</h2>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Detail</th>
                <th>Total Debit</th>
                <th>Total Kredit</th>
                <th>User</th>
            </tr>';

        foreach ($data as $t) {
            $detail_html = '<ul>';
            foreach ($t->details as $d) {
                $detail_html .= "<li>{$d->akun->nama_AkunTransaksi} | Debit: {$d->debit} | Kredit: {$d->kredit}</li>";
            }
            $detail_html .= '</ul>';

            $html .= "<tr>
                        <td>{$t->kode_transaksi}</td>
                        <td>{$t->tanggal_transaksi}</td>
                        <td>{$t->ket_transaksi}</td>
                        <td>{$detail_html}</td>
                        <td>{$t->total_debit}</td>
                        <td>{$t->total_kredit}</td>
                        <td>{$t->data_user?->nama_lengkap}</td>
                      </tr>";
        }

        $html .= '</table>';

        $pdf = Pdf::loadHTML($html);
        return $pdf->download('laporan_transaksi.pdf');
    }
}
