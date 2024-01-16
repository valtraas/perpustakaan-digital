<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori_buku_relasi extends Model
{
    use HasFactory;
    protected $table = 'kategori_buku_relasi';
    protected $guarded =['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori_buku::class);
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class);
    }
}
