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
        // dd(request('kategori'));
        session([
            'penulis' => request('penulis'),
            'tahun_terbit' => request('tahun_terbit'),
            'kategori' => request('kategori'),

        ]);
        return view('laporan.laporan', [
            'title' => 'Print Data',
            'buku' => Buku::Filters(request(['kategori', 'penerbit', 'penulis']))->get(),
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
        $penulis = session('penulis');
        $tahun_terbit = session('tahun_terbit');
        $penerbit = session('penerbit');
        $kategori = session('kategori');
        // dd($penulis);
        return Excel::download(new LaporanExport(penulis: $penulis, tahun_terbit: $tahun_terbit, kategori: $kategori), 'laporan.xlsx');
    }
}
