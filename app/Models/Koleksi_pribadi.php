<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi_pribadi extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $table = 'koleksi_pribadi';
    protected $with = ['buku'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function buku(){
        return $this->belongsTo(Buku::class);
    }
}
