<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        switch ($user->id_role) {
            case 'R04':
                return view('dashboard.simpanan');
            case 'R05':
                return view('dashboard.pinjaman');
            case 'R06':
                return view('dashboard.akunting');
            case 'R07':
                return view('dashboard.pengurus');
            default:
                abort(403, 'Role tidak dikenali');
        }
    }
}
