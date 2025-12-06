<?php

namespace App\Http\Controllers\Admin\TransaksiKas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\JenisAkunTransaksi;
use App\Models\AkunRelasiTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $query = Transaksi::with(['data_user', 'details.akun'])
            ->where('type_transaksi', 'TKK');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_transaksi', [
                $request->start_date . ' 00:00:00',
                $request->end_date   . ' 23:59:59'
            ]);
        }

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'LIKE', "%{$request->search}%");
        }

        $TransaksiPengeluaran = $query->orderByDesc('id_transaksi')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('admin.transaksi_kas.pengeluaran.pengeluaran', compact('TransaksiPengeluaran'));
    }

    public function create()
    {
        $akunSumber = JenisAkunTransaksi::where('pengeluaran', 'Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        $akunTujuan = JenisAkunTransaksi::where('pengeluaran', 'Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        return view('admin.transaksi_kas.pengeluaran.tambah-pengeluaran', compact('akunSumber', 'akunTujuan'));
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
                                        ->where('is_kas', 0)),
            ],

            'sumber' => 'required|array|min:1',

            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => $q->where('pengeluaran', 'Y')
                                        ->where('status_akun', 'Y')
                                        ->where('is_kas', 1)),
            ],

            'sumber.*.jumlah' => 'required|numeric|min:1',
        ]);

        return DB::transaction(function () use ($request) {

            $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

            $t = Transaksi::create([
                'id_user' => Auth::user()->id_user,
                'type_transaksi' => 'TKK',
                'kode_transaksi' => '',
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'ket_transaksi' => $request->ket_transaksi,
                'total_debit' => $total,
                'total_kredit' => $total,
            ]);

            $t->kode_transaksi = 'TKK' . str_pad($t->id_transaksi, 5, '0', STR_PAD_LEFT);
            $t->save();

            foreach ($request->sumber as $s) {
                DetailTransaksi::create([
                    'id_transaksi' => $t->id_transaksi,
                    'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                    'debit' => 0,
                    'kredit' => $s['jumlah'],
                ]);
            }

            DetailTransaksi::create([
                'id_transaksi' => $t->id_transaksi,
                'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
                'debit' => $total,
                'kredit' => 0,
            ]);

            foreach ($request->sumber as $s) {
                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $t->id_transaksi,
                    'id_akun'           => $request->id_akun_tujuan,
                    'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                    'debit'             => $s['jumlah'],
                    'kredit'            => 0,
                    'kode_transaksi'    => $t->kode_transaksi,
                    'tanggal_transaksi' => $t->tanggal_transaksi
                ]);
            }

            foreach ($request->sumber as $s) {
                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $t->id_transaksi,
                    'id_akun'           => $s['id_jenisAkunTransaksi'],
                    'id_akun_berkaitan' => $request->id_akun_tujuan,
                    'debit'             => 0,
                    'kredit'            => $s['jumlah'],
                    'kode_transaksi'    => $t->kode_transaksi,
                    'tanggal_transaksi' => $t->tanggal_transaksi
                ]);
            }

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Transaksi Pengeluaran berhasil ditambahkan');
        });
    }

    public function edit($id)
    {
        $TransaksiPengeluaran = Transaksi::with('details.akun')->findOrFail($id);

        $akunSumber = JenisAkunTransaksi::where('pengeluaran', 'Y')
            ->where('is_kas', 1)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();

        $akunTujuan = JenisAkunTransaksi::where('pengeluaran', 'Y')
            ->where('is_kas', 0)
            ->where('status_akun', 'Y')
            ->orderBy('nama_AkunTransaksi')
            ->get();


        $akun_sumber = $TransaksiPengeluaran->details->where('kredit', '>', 0);
        $akun_tujuan = $TransaksiPengeluaran->details->where('debit', '>', 0)->first();

        return view('admin.transaksi_kas.pengeluaran.edit-pengeluaran', compact(
            'TransaksiPengeluaran',
            'akunSumber',
            'akunTujuan',
            'akun_tujuan',
            'akun_sumber'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string|max:255',

            'id_akun_tujuan' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => 
                        $q->where('pengeluaran', 'Y')
                          ->where('status_akun', 'Y')
                          ->where('is_kas', 0)
                    ),
            ],

            'sumber' => 'required|array|min:1',

            'sumber.*.id_jenisAkunTransaksi' => [
                'required',
                Rule::exists('jenis_akun_transaksi', 'id_jenisAkunTransaksi')
                    ->where(fn($q) => 
                        $q->where('pengeluaran', 'Y')
                          ->where('status_akun', 'Y')
                          ->where('is_kas', 1)
                    ),
            ],

            'sumber.*.jumlah' => 'required|numeric|min:1',
        ]);

        return DB::transaction(function () use ($request, $id) {

            $t = Transaksi::findOrFail($id);

            $total = collect($request->sumber)->sum(fn($s) => $s['jumlah']);

            $t->update([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'ket_transaksi' => $request->ket_transaksi,
                'total_debit' => $total,
                'total_kredit' => $total,
            ]);

            $t->details()->delete();
            AkunRelasiTransaksi::where('id_transaksi', $t->id_transaksi)->delete();

            foreach ($request->sumber as $s) {
                DetailTransaksi::create([
                    'id_transaksi' => $t->id_transaksi,
                    'id_jenisAkunTransaksi' => $s['id_jenisAkunTransaksi'],
                    'debit' => 0,
                    'kredit' => $s['jumlah'],
                ]);
            }

            DetailTransaksi::create([
                'id_transaksi' => $t->id_transaksi,
                'id_jenisAkunTransaksi' => $request->id_akun_tujuan,
                'debit' => $total,
                'kredit' => 0,
            ]);

            foreach ($request->sumber as $s) {
                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $t->id_transaksi,
                    'id_akun'           => $request->id_akun_tujuan,
                    'id_akun_berkaitan' => $s['id_jenisAkunTransaksi'],
                    'debit'             => $s['jumlah'],
                    'kredit'            => 0,
                    'kode_transaksi'    => $t->kode_transaksi,
                    'tanggal_transaksi' => $t->tanggal_transaksi
                ]);         
            }

            foreach ($request->sumber as $s) {
                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $t->id_transaksi,
                    'id_akun'           => $s['id_jenisAkunTransaksi'],
                    'id_akun_berkaitan' => $request->id_akun_tujuan,
                    'debit'             => 0,
                    'kredit'            => $s['jumlah'],
                    'kode_transaksi'    => $t->kode_transaksi,
                    'tanggal_transaksi' => $t->tanggal_transaksi
                ]);
            }

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Data berhasil diperbarui');
        });
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

            return redirect()->route('pengeluaran.index')
                ->with('success', 'Data berhasil dihapus');
        });
    }


    public function exportPdf(Request $request)
    {
    
        $startDate = $request->start_date
            ? $request->start_date . ' 00:00:00'
            : now()->startOfYear();

        $endDate = $request->end_date
            ? $request->end_date . ' 23:59:59'
            : now()->endOfYear();

        $data = Transaksi::with(['details.akun', 'data_user'])
            ->where('type_transaksi', 'TKK')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderByDesc('id_transaksi')
            ->get();

        $pdf = Pdf::loadView('admin.transaksi_kas.pengeluaran.pengeluaran-export-pdf', [
            'data' => $data,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("transaksi_pengeluaran_kas.pdf");
    }

    public function apiIndex(Request $request)
    {
        $query = Transaksi::with(["details.akun"])
            ->where("type_transaksi", "TKK")
            ->orderByDesc("id_transaksi");

        if ($request->filled("start_date") && $request->filled("end_date")) {
            $query->whereBetween("tanggal_transaksi", [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        }

        if ($request->filled("search")) {
            $query->where("kode_transaksi", "LIKE", "%{$request->search}%");
        }

        return response()->json([
            "status" => true,
            "message" => "Data pengeluaran berhasil diambil",
            "data" => $query->get()
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            "tanggal_transaksi" => "required|date",
            "ket_transaksi" => "nullable|string|max:255",
            "id_akun_tujuan" => "required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi",
            "sumber" => "required|array|min:1",
            "sumber.*.id_jenisAkunTransaksi" => "required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi",
            "sumber.*.jumlah" => "required|numeric|min:1",
        ]);

        return DB::transaction(function () use ($request) {

            $total = collect($request->sumber)->sum(fn($s) => $s["jumlah"]);

            $apiUser = 'US012';

            $t = Transaksi::create([
                "id_user" => $apiUser,
                "type_transaksi" => "TKK",
                "kode_transaksi" => "",
                "tanggal_transaksi" => $request->tanggal_transaksi,
                "ket_transaksi" => $request->ket_transaksi,
                "total_debit" => $total,
                "total_kredit" => $total,
            ]);

            $t->kode_transaksi = "TKK" . str_pad($t->id_transaksi, 5, "0", STR_PAD_LEFT);
            $t->save();

            foreach ($request->sumber as $s) {
                DetailTransaksi::create([
                    "id_transaksi" => $t->id_transaksi,
                    "id_jenisAkunTransaksi" => $s["id_jenisAkunTransaksi"],
                    "debit" => 0,
                    "kredit" => $s["jumlah"],
                ]);
            }

            DetailTransaksi::create([
                "id_transaksi" => $t->id_transaksi,
                "id_jenisAkunTransaksi" => $request->id_akun_tujuan,
                "debit" => $total,
                "kredit" => 0,
            ]);

            foreach ($request->sumber as $s) {
                AkunRelasiTransaksi::create([
                    "id_transaksi"      => $t->id_transaksi,
                    "id_akun"           => $request->id_akun_tujuan,
                    "id_akun_berkaitan" => $s["id_jenisAkunTransaksi"],
                    "debit"             => $s["jumlah"],
                    "kredit"            => 0,
                    "kode_transaksi"    => $t->kode_transaksi,
                    "tanggal_transaksi" => $t->tanggal_transaksi
                ]);

                AkunRelasiTransaksi::create([
                    "id_transaksi"      => $t->id_transaksi,
                    "id_akun"           => $s["id_jenisAkunTransaksi"],
                    "id_akun_berkaitan" => $request->id_akun_tujuan,
                    "debit"             => 0,
                    "kredit"            => $s["jumlah"],
                    "kode_transaksi"    => $t->kode_transaksi,
                    "tanggal_transaksi" => $t->tanggal_transaksi
                ]);
            }

            return response()->json([
                "status" => true,
                "message" => "Transaksi pengeluaran berhasil ditambahkan",
                "data" => $t
            ]);
        });
    }

   public function apiUpdate(Request $request, $id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ket_transaksi' => 'nullable|string',
            'id_akun_tujuan' => 'required|integer',
            'sumber' => 'required|array|min:1'
        ]);

        DB::beginTransaction();

        try {
            $totalNominal = collect($validated['sumber'])->sum('jumlah');

            $transaksi->update([
                'tanggal_transaksi' => $validated['tanggal_transaksi'],
                'ket_transaksi'     => $validated['ket_transaksi'] ?? null,
            ]);

            DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();
            AkunRelasiTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();

            foreach ($validated['sumber'] as $sumberItem) {

                $nominal = $sumberItem['jumlah'];
                $akunSumber = $sumberItem['id_jenisAkunTransaksi'];

                DetailTransaksi::create([
                    "id_transaksi"         => $transaksi->id_transaksi,
                    "id_jenisAkunTransaksi" => $akunSumber,
                    "debit"                => 0,
                    "kredit"               => $nominal
                ]);

                DetailTransaksi::create([
                    "id_transaksi"         => $transaksi->id_transaksi,
                    "id_jenisAkunTransaksi" => $validated['id_akun_tujuan'],
                    "debit"                => $nominal,
                    "kredit"               => 0
                ]);

                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $transaksi->id_transaksi,
                    'id_akun'           => $validated['id_akun_tujuan'],
                    'id_akun_berkaitan' => $akunSumber,
                    'debit'             => $nominal,
                    'kredit'            => 0,
                    'kode_transaksi'    => $transaksi->kode_transaksi,
                    'tanggal_transaksi' => $transaksi->tanggal_transaksi
                ]);

                AkunRelasiTransaksi::create([
                    'id_transaksi'      => $transaksi->id_transaksi,
                    'id_akun'           => $akunSumber,
                    'id_akun_berkaitan' => $validated['id_akun_tujuan'],
                    'debit'             => 0,
                    'kredit'            => $nominal,
                    'kode_transaksi'    => $transaksi->kode_transaksi,
                    'tanggal_transaksi' => $transaksi->tanggal_transaksi
                ]);

            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil diperbarui',
                'total_nominal' => $totalNominal,
                'data' => $transaksi
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal update transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function apiDestroy($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {

            DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();

            AkunRelasiTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();

            $transaksi->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Transaksi berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
