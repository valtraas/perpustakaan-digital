<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $guraded = ['id'];

    protected $with = ['users'];

    public function users(){
        return $this->hasMany('users');
    }
}
