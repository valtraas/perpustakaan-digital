<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'Buku';
    protected $guarded = ['id'];
    // protected $with =['peminjaman'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
