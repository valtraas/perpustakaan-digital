<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori_buku;
use App\Models\Kategori_buku_relasi;
use App\Models\Koleksi_pribadi;
use App\Models\Peminjaman;
use App\Models\Ulasan_buku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PinjamBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peminjam.daftar-buku', [
            'title' => 'Daftar Buku',
            'buku' => Buku::with('peminjaman')->filter(request(['kategori']))->get(),
            'kategori' => Kategori_buku::all()

        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tgl_pinjaman = Carbon::now();
        $tgl_pengembalian = $tgl_pinjaman->copy()->addDays(7);;
        $data = [
            'user_id' => $request->input('peminjam'),
            'buku_id' => $request->input('buku'),
            'tgl_peminjaman' => $tgl_pinjaman,
            'tgl_pengembalian' => $tgl_pengembalian,
            'status' => 'Belum Dikembalikan'
        ];

        Peminjaman::create($data);
        return back()->with('success', 'Berhasil meminjam buku');
    }

    public function ulas(Request $request)
    {

        $data = $request->validate([
            'rating' => ['required', 'numeric'],
            'ulasan' => ['required', 'max:255']
        ]);
        $data['users_id'] = $request->input('user');
        $data['buku_id'] = $request->input('buku');
        // dd($data);


        Ulasan_buku::create($data);
        return back()->with('success', 'Berhasil menambahkan ulasan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        $ulasan = Ulasan_buku::where('buku_id', $buku->id)->paginate(2);

        return view('buku.detail', [
            'title' => 'Detail buku',
            'buku' => $buku,
            'ulasan' => $ulasan,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */

    public function ulasanDestroy(Ulasan_buku $ulasan_buku)
    {
        $ulasan_buku->delete();
        return back();
    }
}
