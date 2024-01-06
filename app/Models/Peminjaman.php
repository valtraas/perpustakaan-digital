<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $guarded =['id'];
    protected $with = ['users','buku'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function buku (){
        return $this->belongsTo(Buku::class);
    }
}
