<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanIndex(Request $request)
    {
        return view('laporan.data-laporan');
    }
}
