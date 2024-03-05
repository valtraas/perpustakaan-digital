<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori_buku_relasi;
use App\Models\Koleksi_pribadi;
use App\Models\Ulasan_buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiPribadi extends Controller
{
    public function index()
    {
        return  view('peminjam.koleksi', [
            'title' => 'Koleksi pribadi',
            'koleksi' => Koleksi_pribadi::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function koleksi(Request $request)
    {
        $data = [
            'user_id' => $request->input('user'),
            'buku_id' => $request->input('buku'),
        ];
        Koleksi_pribadi::create($data);
        return back()->with('success', 'Berhasil menambahkan ke koleksi');
    }

    public function show(Buku $daftar_buku)
    {
        $ulasan = Ulasan_buku::where('buku_id', $daftar_buku->id)->paginate(2);
        return view('buku.detail', [
            'title' => 'Detail Buku',
            'buku' => $daftar_buku,
            'ulasan' => $ulasan,
            'kategori' => Kategori_buku_relasi::where('buku_id', $daftar_buku->id)->get()
        ]);
    }

    public function koleksiDestroy(Koleksi_pribadi $koleksi_pribadi)
    {
        $koleksi_pribadi->delete();
        return back();
    }
}
