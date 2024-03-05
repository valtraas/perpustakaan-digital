<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori_buku_relasi;
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
        $buku = Buku::all();

        foreach ($buku as $item) {
            $tersedia = 'Tersedia';
            foreach ($item->peminjaman as $peminjaman) {
                if ($peminjaman->status === 'Disetujui') {
                    $tersedia = 'Disetujui';
                    break;
                }
            }
            $item->tersedia = $tersedia; // Tambahkan properti baru ke setiap buku
        }

        return view('peminjam.daftar-buku', [
            'title' => 'Daftar Buku',
            'buku' => $buku
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $data = [
            'user_id' => $request->input('peminjam'),
            'buku_id' => $request->input('buku'),
            'status' => 'Belum disetujui'
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
            'kategori' => Kategori_buku_relasi::where('buku_id', $buku->id)->get()

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
