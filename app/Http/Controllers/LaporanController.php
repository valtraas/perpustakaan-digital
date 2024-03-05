<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Buku;
use App\Models\Kategori_buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{

    public function laporan()
    {
        return view('laporan.laporan', [
            'title' => 'Print Data',
            'buku' => Buku::all(),
            'peminjam' => Peminjaman::all(),
            'kategori' => Kategori_buku::all()
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

    public function eksport()
    {
        return Excel::download(new LaporanExport(), 'laporan.xlsx');
    }
}
