<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'Buku';
    protected $guarded = ['id'];
    protected $with = ['kategori_buku'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasan_buku()
    {
        return $this->hasMany(Ulasan_buku::class);
    }
    public function kategori_buku()
    {
        return $this->belongsTo(Kategori_buku::class, 'kategori_buku_id', 'id');
    }

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter['kategori'] ?? false, function ($query, $kategori) {
            return $query->whereHas('kategori_buku', function ($query) use ($kategori) {
                $query->where('nama', $kategori);
            });
        });

        $query->when($filter['tahun_terbit'] ?? false, function ($query, $tahun_terbit) {
            return  $query->where('tahun_terbit', $tahun_terbit);
        });
    }
}
