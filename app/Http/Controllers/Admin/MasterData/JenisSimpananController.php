<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\JenisSimpanan;
use Illuminate\Http\Request;

class JenisSimpananController extends Controller
{

        public function index()
    {
         $jenis_simpanan = \App\Models\JenisSimpanan::all();
         return view('admin.master_data.jenis-simpanan', compact('jenis_simpanan'));
    }
    public function create()
    {
        return view('admin.master_data.tambah-jenis-simpanan', [
            'jenis_simpanan' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_simpanan' => 'required|string|max:20',
            'jumlah_simpanan' => 'required|numeric|min:0',
            'tampil_simpanan' => 'required|in:Y,N',
        ]);

        JenisSimpanan::create($validated);

        return redirect()->route('jenis-simpanan.index')
                         ->with('success', 'Jenis simpanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenis_simpanan = JenisSimpanan::findOrFail($id);
        return view('admin.master_data.edit-jenis-simpanan', compact('jenis_simpanan'));
    }

    public function update(Request $request, $id)
    {
        $jenis_simpanan = JenisSimpanan::findOrFail($id);
        $jenis_simpanan->update($request->only(['jenis_simpanan', 'jumlah_simpanan', 'tampil_simpanan']));
        return redirect()->route('jenis-simpanan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis_simpanan = JenisSimpanan::findOrFail($id);
        $jenis_simpanan->delete();
        return redirect()->route('jenis-simpanan.index')->with('success', 'Data berhasil dihapus');
    }
}
