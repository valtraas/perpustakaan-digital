<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DaftarPinjaman extends Controller
{
    public function index()
    {
        return view('peminjaman.peminjaman', [
            'title' => 'Daftar Peminjam',
            'peminjam' => Peminjaman::all(),
        ]);
    }

    public function detail($slug)
    {
        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();


        return view('peminjaman.detail', [
            'title' => 'Daftar Peminjam',
            'peminjam' => $peminjam
        ]);
    }
}
