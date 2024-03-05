<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPermohonanController extends Controller
{
    public function index()
    {
        return view('peminjaman.permohonan', [
            'title' => 'Daftar Permohonan ',
            'peminjam' => Peminjaman::with("buku")->filters(request(['status', 'petugas']))->whereNotIn('status', ['Tepat Waktu', 'Terlambat'])->get(),
            'petugas' => User::with('roles')->where('roles_id', '2')->get(),
        ]);
    }

    public function setuju($slug)
    {

        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();
        $tgl_pinjaman = Carbon::now();
        // dd($tgl_pinjaman);
        $tgl_pengembalian = $tgl_pinjaman->copy()->addDays(7);
        $buku = Buku::where('slug', $slug)->first();
        $buku->update([
            'stock' => $buku->stock - 1
        ]);
        $peminjam->update([
            'status' => 'Disetujui',
            'tgl_peminjaman' => $tgl_pinjaman,
            'tgl_pengembalian' => $tgl_pengembalian,
            'penanggung_jawab' => Auth::user()->username

        ]);

        return back()->with('success', 'Berhasil menyutujui peminjam');
    }

    public function penolakan($slug)
    {
        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();
        $buku = Buku::where('slug', $slug)->first();

        if ($peminjam->status === 'Disetujui') {
            $buku->update([
                'stock' => $buku->stock + 1
            ]);
            $peminjam->update([
                'status' => 'Ditolak',

            ]);
        } else {
            $peminjam->update([
                'status' => 'Ditolak',
                'penanggung_jawab' => Auth::user()->username

            ]);
        }

        return back()->with('success', 'Berhasil menolak peminjam');
    }

    public function perpanjang(Request $request, $slug)
    {
        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        });
        // dd($peminjam);
        $peminjam->update([
            'tgl_pengembalian' => $request->input('perpanjang'),
            'keterangan' => 'Perpanjangan Disetujui'
        ]);
        return back()->with('success', 'Berhasil menyetujui perpanjangan');
    }

    public function tolakPerpanjangan($slug)
    {
        // dd('tolak');
        $peminjam = Peminjaman::whereHas('buku', function ($query) use ($slug) {
            $query->where('slug', $slug);
        });
        // dd($peminjam);
        $peminjam->update([
            'keterangan' => 'Perpanjangan ditolak'
        ]);
        return back()->with('success', 'Berhasil menolak perpanjangan');
    }
}
