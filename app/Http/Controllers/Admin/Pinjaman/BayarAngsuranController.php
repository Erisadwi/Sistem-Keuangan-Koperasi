namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Illuminate\Support\Facades\Auth;

class BayarAngsuranController extends Controller
{

    public function show($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);

        $payments = Angsuran::where('id_pinjaman', $id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        $totalBayar = $payments->sum('jumlah');
        $sisaAngsuran = max(0, $pinjaman->lama_pinjaman - $payments->count());
        $sisaTagihan = max(0, $pinjaman->total_pinjaman - $totalBayar);
        
        $pinjaman->sisa_angsuran = $sisaAngsuran;
        $pinjaman->sudah_dibayar = $totalBayar;
        $pinjaman->denda = $payments->sum('denda');
        $pinjaman->sisa_tagihan = $sisaTagihan;
        $pinjaman->status = $sisaAngsuran == 0 ? 'Lunas' : 'Belum Lunas';

        return view('admin.pinjaman.bayar_angsuran', compact('pinjaman', 'payments'));
    }
}