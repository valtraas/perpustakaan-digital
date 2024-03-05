<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PesanBukuController extends Controller
{
    public function index()
    {
        return view('peminjam.buku-dipesan', [
            'title' => 'Permohonan Buku',
            'buku' => Peminjaman::with('buku')->whereNotIn('status', ['Disetujui'])->get(),

        ]);
    }


    public function batalPesan($buku)
    {
        $pesan_buku =    Peminjaman::whereHas('buku', function ($query) use ($buku) {
            $query->where('slug', $buku);
        })->first();
        $buku_model = new Buku();
        $buku_pinjam = $buku_model->where('slug', $buku)->first();
        // dd($buku_pinjam);
        $buku_pinjam->update(['stock' => $buku_pinjam->stock + 1]);

        $pesan_buku->delete();
        return back();
    }
}
