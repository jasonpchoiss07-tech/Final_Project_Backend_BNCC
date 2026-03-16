<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;

class KatalogController extends Controller
{
    public function index()
    {
        $barang   = Barang::with('kategori')->latest()->paginate(12);
        $kategoris = KategoriBarang::all();
        return view('user.katalog.index', compact('barang', 'kategoris'));
    }
}
