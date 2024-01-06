<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan_buku extends Model
{
    use HasFactory;
    protected $table = 'ulasan_buku';
    protected $guarded =['id'];

    protected $with =['users','buku'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function buku(){
        return $this->belongsTo(Buku::class);
    }
}
