<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use App\Exports\JenisAkunTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class JenisAkunTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search  = $request->query('search');

        $query = JenisAkunTransaksi::query();

        if (!empty($search)) {
            $query->where('kode_aktiva', 'LIKE', "%{$search}%");
        }

        $jenis_akun_transaksi = $query->orderBy('id_jenisAkunTransaksi', 'asc')
            ->paginate($perPage)
            ->appends(['search' => $search]);

        return view('admin.master_data.jenis-akun-transaksi', compact('jenis_akun_transaksi', 'search'));
    }

    public function export()
    {
        return Excel::download(new JenisAkunTransaksiExport, 'jenis_akun_transaksi.xlsx');
    }

    public function create()
    {
        return view('admin.master_data.tambah-data-jenis-akun-transaksi', [
            'jenis_akun_transaksi' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aktiva'        => 'required|string|max:20|unique:jenis_akun_transaksi,kode_aktiva',
            'nama_AkunTransaksi' => 'required|string|max:100',
            'type_akun'          => 'required|in:ACTIVA,PASIVA',
            'pemasukan'          => 'required|in:Y,N',
            'pengeluaran'        => 'required|in:Y,N',
            'penarikan'          => 'required|in:Y,N',
            'transfer'           => 'required|in:Y,N',
            'status_akun'        => 'required|in:Y,N',
            'nonkas'             => 'required|in:Y,N',
            'simpanan'           => 'required|in:Y,N',
            'pinjaman'           => 'required|in:Y,N',
            'angsuran'           => 'required|in:Y,N',
            'labarugi'           => 'required|in:PENDAPATAN,BIAYA',
        ]);

        JenisAkunTransaksi::create($validated);

        return redirect()->route('jenis-akun-transaksi.index')
            ->with('success', 'Jenis akun transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenis_akun_transaksi = JenisAkunTransaksi::findOrFail($id);
        return view('admin.master_data.edit-data-jenis-akun-transaksi', compact('jenis_akun_transaksi'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_aktiva'        => 'required|string|max:20|unique:jenis_akun_transaksi,kode_aktiva,' . $id . ',id_jenisAkunTransaksi',
            'nama_AkunTransaksi' => 'required|string|max:100',
            'type_akun'          => 'required|in:ACTIVA,PASIVA',
            'pemasukan'          => 'required|in:Y,N',
            'pengeluaran'        => 'required|in:Y,N',
            'penarikan'          => 'required|in:Y,N',
            'transfer'           => 'required|in:Y,N',
            'status_akun'        => 'required|in:Y,N',
            'nonkas'             => 'required|in:Y,N',
            'simpanan'           => 'required|in:Y,N',
            'pinjaman'           => 'required|in:Y,N',
            'angsuran'           => 'required|in:Y,N',
            'labarugi'           => 'required|in:PENDAPATAN,BIAYA',
        ]);

        $jenis_akun_transaksi = JenisAkunTransaksi::findOrFail($id);
        $jenis_akun_transaksi->update($validated);

        return redirect()->route('jenis-akun-transaksi.index')
            ->with('success', 'Data berhasil diperbarui');
    }
}
