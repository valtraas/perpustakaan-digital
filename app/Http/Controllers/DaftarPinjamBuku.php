<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Peminjam;
use App\Models\Peminjaman;
use App\Models\Ulasan_buku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DaftarPinjamBuku extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batas = Peminjaman::with('buku')->where('tgl_pengembalian', '<=',  now('Asia/Jakarta')->format('Y-m-d'))->where('status', 'Disetujui')->get();
        if ($batas->count() !== 0) {
            session()->flash('warning', $batas->count());
        } else {
            $batas = Peminjaman::with('buku')->where('status', 'Disetujui')->get();
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
            'keterangan' => $request->input('tgl_pengembalian'),
        ]);
        return back()->with('success', 'Berhasil meminta perpanjangan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $daftar_buku_pinjaman)
    {
        if ($daftar_buku_pinjaman->tgl_pengembalian < Carbon::now()) {
            $status = 'Terlambat';
        } else {
            $status = 'Tepat Waktu';
        }



        $daftar_buku_pinjaman->update([
            'status' => $status
        ]);
        return back();
    }
    public function bukuKembali(Request $request, $buku_pinjam)
    {
        if ($request->input('rating')) {
            $data = $request->validate([
                'rating' => ['nullable'],
                'ulasan' => ['max:255'],
            ]);
            $data['users_id'] = $request->input('user');
            $data['buku_id'] = $request->input('buku');
            // dd($data);
            Ulasan_buku::create($data);
        }
        $buku_kembali = $request->validate([
            'status' => 'required'
        ]);
        

        $buku = Peminjaman::where('id', $buku_pinjam)->first();
        // dd($buku);
        if ($buku->tgl_pengembalian < Carbon::now()) {
            dd('masuk');
        }
        dd("keluar");
        $buku->update([
            'status' => $buku_kembali
        ]);
        // $buku->delete();
        return back()->with('success', 'Berhasil mengembalikan buku');
    }
}
