<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'Buku';
    protected $guarded = ['id'];
    // protected $with = ['peminjaman', 'ulasan_buku'];

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

    public function kategori()
    {
        return $this->belongsToMany(Kategori_buku::class, 'kategori_buku_relasi')->withTimestamps();
    }

    public function kategori_buku_relasi()
    {
        return $this->hasMany(Kategori_buku_relasi::class);
    }

    public function scopeFilters($query, array $filter)
    {
        $query->when($filter['penulis'] ?? false, function ($query, $penulis) {
            return $query->where('penulis', $penulis);
        });
        $query->when($filter['penerbit'] ?? false, function ($query, $penerbit) {
            return $query->where('penerbit', $penerbit);
        });
        $query->when($filter['kategori'] ?? false, function ($query, $kategori) {
            return $query->whereHas('kategori_buku_relasi', function ($query) use ($kategori) {
                $query->whereIn('kategori_buku_id', $kategori);
            }, '=', count($kategori));
        });
        
    }

   

}
