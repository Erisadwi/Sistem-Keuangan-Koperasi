<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function simpanan()
    {
        return view('dashboard.simpanan');
    }

    public function pinjaman()
    {
        return view('dashboard.pinjaman');
    }

    public function akunting()
    {
        return view('dashboard.akunting');
    }

    public function pengurus()
    {
        return view('dashboard.pengurus');
    }
}
