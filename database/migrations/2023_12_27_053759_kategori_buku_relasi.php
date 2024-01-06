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
        Schema::create('kategori_buku_relasi',function(Blueprint $table){
            $table->id();
            $table->foreignId('buku_id')->constrained(table:'buku');
            $table->foreignId('kategori_id')->constrained(table:'kategori_buku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_buku_relasi');
    }
};
