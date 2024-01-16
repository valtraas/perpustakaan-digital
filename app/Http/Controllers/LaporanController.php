<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function laporan()
    {
        return view('laporan.laporan', [
            'title' => 'Print data',
            'buku' => Buku::all(),
            'peminjam' => Peminjaman::filters(request(['tgl_peminjaman', 'tgl_pengembalian']))->get()
        ]);
    }


    public function print()
    {
        return view('laporan.print-all', [
            'title' => 'Print Data',
            'peminjam' => Peminjaman::filters(request(['tgl_peminjaman', 'tgl_pengembalian']))->get(),
            'belum_dikembalikan' => Peminjaman::filters(request(['tgl_peminjaman', 'tgl_pengembalian']))->where('status', 'Belum Dikembalikan')->get(),
            'dikembalikan' => Peminjaman::filters(request(['tgl_peminjaman', 'tgl_pengembalian']))->where('status', 'Dikembalikan')->get(),
        ]);
    }
}
