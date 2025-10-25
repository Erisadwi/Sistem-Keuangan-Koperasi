<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\LamaAngsuran;
use Illuminate\Http\Request;

class LamaAngsuranController extends Controller
{

        public function index()
    {
         $lama_angsuran = \App\Models\LamaAngsuran::all();
         return view('admin.master_data.lama-angsuran', compact('lama_angsuran'));
    }
    public function create()
    {
        return view('admin.master_data.tambah-data-lama-angsuran', [
            'lama_angsuran' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lama_angsuran'      => 'required|numeric',
            'status_angsuran'    => 'required|in:Y,T',
        ]);

        $validated['id_lamaAngsuran'] = LamaAngsuran::generateId();
        LamaAngsuran::create($validated);

        return redirect()->route('lama-angsuran.index')
                         ->with('success', 'Data lama angsuran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lama_angsuran = LamaAngsuran::findOrFail($id);
        return view('admin.master_data.edit-data-lama-angsuran', compact('lama_angsuran'));
    }

    public function update(Request $request, $id)
    {
        $lama_angsurann = LamaAngsuran::findOrFail($id);
        $lama_angsurann->update($request->only(['lama_angsuran', 'status_angsuran']));
        return redirect()->route('lama-angsuran.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lama_angsuran = LamaAngsuran::findOrFail($id);
        $lama_angsuran->delete();
        return redirect()->route('lama-angsuran.index')->with('success', 'Data berhasil dihapus');
    }
}
