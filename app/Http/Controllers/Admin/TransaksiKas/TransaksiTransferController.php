<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\AkunRelasiTransaksi;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiTransferController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
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

        $TransaksiTransfer = $query->orderBy('id_transaksi', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.transfer.transfer', compact('TransaksiTransfer'));
    }

    public function apiIndex()
    {
        $data = Transaksi::orderBy('tanggal_transaksi', 'desc')->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        return view('admin.transaksi_kas.transfer.tambah-transfer', compact('akunSumber', 'akunTujuan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'tanggal_transaksi' => 'required|date',
        'ket_transaksi' => 'nullable|string|max:255',
        'id_akun_tujuan' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('transfer', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 1)), 
        ],
        'sumber' => 'required|array|min:1',
        'sumber.*.id_jenisAkunTransaksi' => [
            'required',
            Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                ->where(fn($q) => $q->where('transfer', 'Y')
                                    ->where('status_akun', 'Y')
                                    ->where('is_kas', 1)), 
        ],
        'sumber.*.jumlah' => 'required|numeric|min:1',
    ]);


        $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

        $transaksi = Transaksi::create([
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TRF',
            'kode_transaksi' => '',
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'total_debit' => $total,
            'total_kredit' => $total,
        ]);

        $transaksi->kode_transaksi = 'TRF' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
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

        $idTransaksi = $transaksi->id_transaksi;
        $kode = $transaksi->kode_transaksi;
        $tanggal = $transaksi->tanggal_transaksi;

        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $request->id_akun_tujuan,
                'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                'debit' => $s['jumlah'],
                'kredit' => 0,
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }


        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $s['id_jenisAkunTransaksi'],
                'id_akun_berkaitan' => $request->id_akun_tujuan,
                'debit' => 0,
                'kredit' => $s['jumlah'],
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }

        return redirect()->route('transaksi-transfer.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'no_bukti'         => 'required|string',
            'tgl_transaksi'    => 'required|date',
            'akun_sumber'      => 'required|exists:jenis_akun_transaksi,id',
            'akun_tujuan'      => 'required|exists:jenis_akun_transaksi,id',
            'nominal'          => 'required|numeric|min:1',
            'keterangan'       => 'nullable|string',
        ]);

        if ($request->akun_sumber == $request->akun_tujuan) {
            return response()->json([
                'status' => false,
                'message' => 'Akun sumber dan tujuan tidak boleh sama'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $source = JenisAkunTransaksi::find($request->akun_sumber);
            $target = JenisAkunTransaksi::find($request->akun_tujuan);

            if ($source->saldo < $request->nominal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Saldo akun sumber tidak mencukupi'
                ], 422);
            }

            $source->saldo -= $request->nominal;
            $source->save();

            $target->saldo += $request->nominal;
            $target->save();

            $data = TransaksiTransfer::create($validated);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi transfer berhasil disimpan',
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $TransaksiTransfer = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akunTujuan = JenisAkunTransaksi::where('transfer','Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')->get();

        $akun_tujuan = $TransaksiTransfer->details->firstWhere('debit', '>', 0);
        $akun_sumber = $TransaksiTransfer->details->where('kredit', '>', 0)->values();

        return view('admin.transaksi_kas.transfer.edit-transfer', compact('TransaksiTransfer', 'akunSumber', 'akunTujuan', 'akun_tujuan', 'akun_sumber'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string|max:255',
            'id_akun_tujuan' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('transfer', 'Y')
                                        ->where('is_kas', 1)), 
            ],
            'sumber' => 'required|array|min:1',
            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('transfer', 'Y')
                                        ->where('is_kas', 1)), 
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

        AkunRelasiTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();

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

        $idTransaksi = $transaksi->id_transaksi;
        $kode = $transaksi->kode_transaksi;
        $tanggal = $transaksi->tanggal_transaksi;

        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $request->id_akun_tujuan,
                'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                'debit' => $s['jumlah'],
                'kredit' => 0,
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }

        foreach ($request->sumber as $s) {
            AkunRelasiTransaksi::create([
                'id_transaksi' => $idTransaksi,
                'id_akun' => $s['id_jenisAkunTransaksi'],
                'id_akun_berkaitan' => $request->id_akun_tujuan,
                'debit' => 0,
                'kredit' => $s['jumlah'],
                'kode_transaksi' => $kode,
                'tanggal_transaksi' => $tanggal
            ]);
        }

        return redirect()->route('transaksi-transfer.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = Transaksi::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => false,
            'message' => 'Transaksi transfer tidak dapat diupdate. Silakan hapus dan buat baru.'
        ], 405);
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $t = Transaksi::findOrFail($id);

            DetailTransaksi::where('id_transaksi', $id)->delete();

            if (class_exists(\App\Models\AkunRelasiTransaksi::class)) {
                \App\Models\AkunRelasiTransaksi::where('id_transaksi', $id)->delete();
            }

            $t->delete();

            return redirect()->route('transaksi-transfer.index')
                ->with('success', 'Data berhasil dihapus');
        });
    }

    public function apiDestroy($id)
    {
        $data = Transaksi::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $source = JenisAkunTransaksi::find($data->akun_sumber);
            $target = JenisAkunTransaksi::find($data->akun_tujuan);

            $source->saldo += $data->nominal;
            $source->save();

            $target->saldo -= $data->nominal;
            $target->save();

            $data->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi transfer berhasil dihapus & saldo dikembalikan'
            ]);

        } catch (\Throwable $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['details.akun', 'data_user'])
            ->where('type_transaksi', 'TRF');

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $periodStart = $request->start_date . ' 00:00:00';
            $periodEnd   = $request->end_date . ' 23:59:59';

            $query->whereBetween('tanggal_transaksi', [$periodStart, $periodEnd]);

        } else {

            $tahun = date('Y');

            $periodStart = $tahun . '-01-01 00:00:00';
            $periodEnd   = $tahun . '-12-31 23:59:59';

            $query->whereBetween('tanggal_transaksi', [$periodStart, $periodEnd]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $data = $query->orderBy('id_transaksi', 'desc')->get();

        return Pdf::loadView('admin.transaksi_kas.transfer.transfer-export-pdf', [
            'data'        => $data,
            'periodStart' => $periodStart,
            'periodEnd'   => $periodEnd,
        ])->setPaper('A4', 'landscape')
        ->download('transaksi_transfer_kas.pdf');
    }

}
