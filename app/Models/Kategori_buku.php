<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_buku extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kategori_buku';

    function getRouteKeyName()
    {
        return 'slug';
    }

    public function buku()
    {
        return $this->hasMany(Buku::class);
    }
}
