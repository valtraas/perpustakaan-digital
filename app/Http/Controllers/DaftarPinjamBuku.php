<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Peminjam;
use App\Models\Peminjaman;
use App\Models\Ulasan_buku;
use Illuminate\Http\Request;

class DaftarPinjamBuku extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batas = Peminjaman::with('buku')->where('tgl_pengembalian', '<=',  now('Asia/Jakarta')->format('Y-m-d'))->get();
        if ($batas->count() !== 0) {
            session()->flash('warning', $batas->count());
        } else {
            $batas = Peminjaman::with('buku')->get();
            // dd($batas);
        }
        return view('peminjam.buku-dipinjam', [
            'title' => 'Daftar buku yang dipinjam',
            'buku' => $batas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $daftar_buku_pinjaman)
    {
        $daftar_buku_pinjaman->update([
            'tgl_pengembalian' => $request->input('tgl_pengembalian'),
        ]);
        return back()->with('success', 'Berhasil memperpanjang peminjaman');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $daftar_buku_pinjaman)
    {
        $daftar_buku_pinjaman->delete();
        return back();
    }
    public function bukuKembali(Request $request, $buku_pinjam)
    {
        $data = $request->validate([
            'rating' => ['required', 'numeric'],
            'ulasan' => ['required', 'max:255']
        ]);
        $data['users_id'] = $request->input('user');
        $data['buku_id'] = $request->input('buku');
        // dd($data);
        Ulasan_buku::create($data);

        $buku = Peminjaman::where('id', $buku_pinjam)->first();
        $buku->delete();
        return back()->with('success', 'Berhmasil mengembalikan buku');
    }
}
