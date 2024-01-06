<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman',function(Blueprint $table){
            $table->id();
            $table->foreignId('users_id')->constrained(table:'users');
            $table->foreignId('buku_id')->constrained(table:'buku');
            $table->date('tgl_peminjaman');
            $table->date('tgl_pengembalian');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
