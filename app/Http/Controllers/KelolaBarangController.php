<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class KelolaBarangController extends Controller
{
    public function index()
    {
        return view('pages.kelola_barang');
    }
}
