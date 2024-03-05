<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_buku extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kategori_buku';


    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'kategori_buku_relasi')->withTimestamps();
    }

    public function kategori_buku_relasi()
    {
        return $this->hasMany(Kategori_buku_relasi::class, 'kategori_id');
    }

    function getRouteKeyName()
    {
        return 'slug';
    }
}
