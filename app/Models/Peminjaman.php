<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $guarded =['id'];
    // protected $with = ['user', 'buku'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku (){
        return $this->belongsTo(Buku::class);
    }
    public function scopeFilters($query, array $filters)
    {

        $query->when($filters['bulan_pengembalian'] ?? false, function ($query, $pengembalian) {
            $bulan_pengembalian = Carbon::createFromFormat('Y-m', $pengembalian)->startOfMonth();
            $bulan = $bulan_pengembalian->month;
            $tahun = $bulan_pengembalian->year;
            return $query->whereMonth('tgl_pengembalian', $bulan)->whereYear('tgl_pengembalian', $tahun);
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            return $query->where('status', $status);
        });
        $query->when($filters['petugas'] ?? false, function ($query, $petugas) {
            return $query->where('penanggung_jawab', $petugas);
        });

    }

    // public function remove_buku()
    // {
    //     $data = Peminjaman::where('tgl_pengembalian', now('Asia/Jakarta')->format('Y-m-d'))->get();
    //     foreach ($data as $item) {
    //         $item->delete();
    //     }
    // }
}
