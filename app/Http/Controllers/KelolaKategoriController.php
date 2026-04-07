<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaKategoriController extends Controller
{
    public function index()
    {
        return view('admin.kelola_kategori');
    }
}
