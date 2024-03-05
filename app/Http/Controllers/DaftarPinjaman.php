<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Peminjam;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPinjaman extends Controller
{
    public function index()
    {
        $petugas = Peminjaman::with("buku")->filters(request(['bulan_pengembalian', 'status']))->where('penanggung_jawab', Auth::user()->username)->whereNotIn('status', ['Ditolak'])->get();
        $admin = Peminjaman::with("buku")->filters(request(['bulan_pengembalian', 'status', 'penanggung_jawab']))->whereNotIn('status', ['Ditolak'])->get();

        if (Auth::user()->roles_id == 1) {
            $data = $admin;
        } elseif (Auth::user()->roles_id == 2) {
            $data = $petugas;
        }
        return view('peminjaman.peminjaman', [
            'title' => 'Daftar Peminjam',
            'peminjam' => $data,
        ]);
    }

    public function detail($slug)
    {
        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();


        return view('peminjaman.detail', [
            'title' => 'Daftar Peminjam',
            'peminjam' => $peminjam
        ]);
    }

    public function setuju(Request $request, $slug)
    {
        // dd('setuju');

        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();
        $tgl_pinjaman = Carbon::now();
        $tgl_pengembalian = $tgl_pinjaman->copy()->addDays(7);
        $peminjam->update([
            'status' => 'Disetujui',
            'tgl_pinjaman' => $tgl_pinjaman,
            'tgl_pengembalian' => $tgl_pengembalian

        ]);

        return back()->with('success', 'Berhasil menyutujui peminjam');
    }
}
