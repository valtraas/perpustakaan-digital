<?php

namespace App\Models;

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
        $query->when($filters['tgl_peminjaman'] ?? false, function ($query, $peminjaman) {
            return $query->whereDate('tgl_peminjaman', $peminjaman);
        });
        $query->when($filters['tgl_pengembalian'] ?? false, function ($query, $pengembalian) {
            return $query->whereDate('tgl_pengembalian', $pengembalian);
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
