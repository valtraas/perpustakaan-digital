<?php

namespace App\Http\Controllers;

use App\Models\Buku;
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

    public function show($buku)
    {
        $koleksi_detail = Buku::where('id', $buku)->first();
        $ulasan = Ulasan_buku::where('buku_id', $buku)->paginate(2);

        return view('buku.detail', [
            'title' => 'Detail buku',
            'buku' => $koleksi_detail,
            'ulasan' => $ulasan
        ]);
    }

    public function koleksiDestroy(Koleksi_pribadi $koleksi_pribadi)
    {
        $koleksi_pribadi->delete();
        return back();
    }
}
