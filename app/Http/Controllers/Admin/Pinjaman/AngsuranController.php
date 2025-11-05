<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;

class AngsuranController extends Controller
{
    public function index()
    {
        return view('admin.pinjaman.angsuran');
    }
}

