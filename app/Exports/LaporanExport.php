<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $penulis = null;
    private $tahun_terbit = null;
    private $kategori = [];

    public function __construct($penulis = null, $tahun_terbit = null, $kategori = [])
    {
        $this->penulis = $penulis;
        $this->tahun_terbit = $tahun_terbit;
        $this->kategori = $kategori;
    }

    public function sheets(): array
    {
        $sheets = [];
        // dd($this->kategori);
        // Buat sheet pertama
        $sheets["Buku"] = new BukuSheets($this->penulis, $this->tahun_terbit, $this->kategori);
        $sheets[] = new PeminjamSheets();
        // Buat sheet lain jika diperlukan
        // $sheets[] = new NamaSheet($argumen1, $argumen2);

        return $sheets;
    }
}
