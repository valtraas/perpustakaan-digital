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

    
}
