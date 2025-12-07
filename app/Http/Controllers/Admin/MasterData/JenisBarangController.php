<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JenisBarangInventarisExport;

class JenisBarangController extends Controller
{

        public function index(Request $request)
    {
         $jenis_barang = JenisBarang::all();

        $perPage = (int) $request->query('per_page', 10);
        $query = JenisBarang::query();
        $jenis_barang = $query->orderBy('id_barangInventaris', 'asc')->paginate($perPage);
         return view('admin.master_data.data-barang', compact('jenis_barang'));
    }
    public function create()
    {
        return view('admin.master_data.tambah-data-barang', [
            'jenis_barang' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'        => 'required|string',
            'type_barang'        => 'nullable|string',
            'jumlah_barang'      => 'required|numeric',
            'keterangan_barang'  => 'nullable|string',
        ]);

        $validated['id_barangInventaris'] = JenisBarang::generateId();
        JenisBarang::create($validated);

        return redirect()->route('jenis-barang.index')
                         ->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenis_barang = JenisBarang::findOrFail($id);
        return view('admin.master_data.edit-data-barang', compact('jenis_barang'));
    }

    public function update(Request $request, $id)
    {
        $jenis_barang = JenisBarang::findOrFail($id);
        $jenis_barang->update($request->only(['nama_barang', 'type_barang', 'jumlah_barang', 'keterangan_barang']));
        return redirect()->route('jenis-barang.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis_barang = JenisBarang::findOrFail($id);
        $jenis_barang->delete();
        return redirect()->route('jenis-barang.index')->with('success', 'Data berhasil dihapus');
    }

    public function export()
    {
    return Excel::download(new JenisBarangInventarisExport, 'jenis-barang-inventaris.xlsx');
    }

    public function apiIndex(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        $data = JenisBarang::orderBy('id_barangInventaris', 'asc')
                           ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data jenis barang berhasil diambil',
            'data' => $data
        ]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'        => 'required|string',
            'type_barang'        => 'nullable|string',
            'jumlah_barang'      => 'required|numeric',
            'keterangan_barang'  => 'nullable|string',
        ]);

        $validated['id_barangInventaris'] = JenisBarang::generateId();

        $jenisBarang = JenisBarang::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil ditambahkan',
            'data' => $jenisBarang
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $jenisBarang->update(
            $request->only(['nama_barang', 'type_barang', 'jumlah_barang', 'keterangan_barang'])
        );

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diperbarui',
            'data' => $jenisBarang
        ]);
    }

    public function apiDestroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dihapus'
        ]);
    }
}
