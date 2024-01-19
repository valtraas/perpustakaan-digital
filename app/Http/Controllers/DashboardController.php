<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori_buku;
use App\Models\Koleksi_pribadi;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        $peminjaman = Peminjaman::Where('status', 'Belum Dikembalikan')->get();
        $buku_tersedia = $buku->count() - $peminjaman->count();
        return view('dashboard.dashmain', [
            'title' => 'Dashboard',
            'buku' => Buku::all(),
            'kategori' => Kategori_buku::all(),
            'peminjam' => Peminjaman::where('status', 'Belum Dikembalikan')->get(),
            'buku_tersedia' => $buku_tersedia,
            'koleksi' => Koleksi_pribadi::all(),
            'buku_dipinjam' => Peminjaman::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function graph()
    {
        $endDate = now();
        $startdate = $endDate->copy()->subDays(6);
        $user_role = auth()->user()->roles->nama;
        $data = [];

        if ($user_role !== 3) {
            $data = $this->getDataForNonPeminjam($startdate, $endDate);
        }
        return response()->json($data);
    }

    public function getDataForNonPeminjam($startdate, $endDate)
    {
        $data = DB::table('peminjaman')->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startdate, $endDate])
            ->groupBy('date')->get();
        return $this->formatData($data, $startdate, $endDate);
    }

    private function formatData($data, $startDate, $endDate)
    {
        $weeklyData = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('j M Y');
            $totalBarang = $data->firstWhere('date', $currentDate->toDateString())->total ?? 0;
            $weeklyData[] = [
                'date' => $formattedDate,
                'total_peminjam' => $totalBarang,
            ];
            $currentDate->addDay();
        }

        return $weeklyData;
    }
}
