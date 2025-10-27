<?php

namespace App\Http\Controllers\Admin\setting;
use App\Http\Controllers\Controller;
use App\Models\sukuBunga;
use Illuminate\Http\Request;

class SukuBungaController extends Controller
{
    public function edit()
    {
    $suku_bunga = sukuBunga::firstOrFail();
    return view('admin.setting.suku-bunga', compact('suku_bunga'));
    }

    public function update(Request $request)
    {   
        $validated = $request->validate([
        'tipe_pinjaman_bunga'      => 'required|in:A: Persen Bunga dikali angsuran bln,B: Persen Bunga dikali total pinjaman',
        'suku_bunga_pinjaman'      => 'required|numeric',
        'biaya_administrasi'       => 'required|numeric',
        'biaya_denda'              => 'required|numeric',
        'tempo_tanggal_pembayaran' => 'required|numeric',
        'iuran_wajib'              => 'required|numeric',
        'dana_cadangan'            => 'required|numeric',
        'jasa_usaha'               => 'required|numeric',
        'jasa_anggota'             => 'required|numeric',
        'jasa_modal_anggota'       => 'required|numeric',
        'dana_pengurus'            => 'required|numeric',
        'dana_karyawan'            => 'required|numeric',
        'dana_pendidikan'          => 'required|numeric',
        'dana_sosial'              => 'required|numeric',
        'pajak_pph'                => 'required|numeric',
        ]);
        
        $suku_bunga = sukuBunga::firstOrFail();
        $suku_bunga->update($validated);

        return redirect()
                ->route('suku-bunga.editSingle')
                ->with('success', 'Data berhasil diperbarui');
    }

}
