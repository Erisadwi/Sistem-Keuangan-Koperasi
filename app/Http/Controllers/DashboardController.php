<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\KasService;
use App\Services\PinjamanDashboardService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $kas;
    protected $pinjamanService;

    public function __construct(KasService $kas, PinjamanDashboardService $pinjamanService)
    {
        $this->kas = $kas;
        $this->pinjamanService = $pinjamanService;
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $pinjamanCard = $this->pinjamanService->getSummary();

        $kas = $this->kas->getSaldoKas();

        $bulan = date('m');
        $tahun = date('Y');

        $bulanName = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)
                    ->translatedFormat('F');

        $anggota_aktif = DB::table('anggota')->where('status_anggota', 'Aktif')->count();
        $anggota_nonaktif = DB::table('anggota')->where('status_anggota', 'Non Aktif')->count();
        $anggota_total = DB::table('anggota')->count();

        $peminjam_total = DB::table('pinjaman')->count();
        $peminjam_lunas = DB::table('pinjaman')->where('status_lunas','LUNAS')->count();
        $peminjam_belum = DB::table('pinjaman')->where('status_lunas','BELUM LUNAS')->count();

        $user_aktif = User::where('status','aktif')->count();
        $user_nonaktif = User::where('status','nonaktif')->count();
        $user_total = User::count();

        $data = [
            'pinjaman_tagihan'   => $pinjamanCard['tagihan'],
            'pinjaman_pelunasan' => $pinjamanCard['pelunasan'],
            'pinjaman_sisa'      => $pinjamanCard['sisa'],

            'saldo_awal'  => $kas['saldo_awal'],
            'mutasi'      => $kas['mutasi'],
            'saldo_akhir' => $kas['saldo_akhir'],

            'bulanName' => $bulanName,
            'tahun'     => $tahun,

            'anggota_aktif' => $anggota_aktif,
            'anggota_nonaktif' => $anggota_nonaktif,
            'anggota_total' => $anggota_total,

            'peminjam_total' => $peminjam_total,
            'peminjam_lunas' => $peminjam_lunas,
            'peminjam_belum' => $peminjam_belum,

            'user_aktif' => $user_aktif,
            'user_nonaktif' => $user_nonaktif,
            'user_total' => $user_total,
        ];

        switch ($user->id_role) {
            case 'R04':
            case 'R05':
            case 'R06':
            case 'R07':
                return view('dashboard.pengurus', $data);

            default:
                abort(403,'Role tidak dikenali');
        }
    }
}
