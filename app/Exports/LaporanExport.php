<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
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

    public function headings(): array
    {
        return [
            'Judul',
            'Penulis',
            'Penerbit',
            'Tahun Terbit',
            'Stock',
        ];
    }

    public function collection()
    {
        $query = Buku::query();

        if ($this->penulis !== null) {
            $query->where('penulis', $this->penulis);
        }

        if ($this->tahun_terbit !== null) {
            $query->where('tahun_terbit', $this->tahun_terbit);
        }
        if (!empty($this->kategori)) {
            $query->whereHas('kategori', function ($query) {
                $query->where('nama', $query);
            });
        }
        // Jika ketiga variabel kosong, kembalikan semua data
        if ($this->penulis === null && $this->tahun_terbit === null) {
            return Buku::all();
        }

        // Eksekusi query dan kembalikan hasilnya sebagai koleksi
        return $query->get();
    }
    public function map($buku): array
    {
        return [
            $buku->judul,
            $buku->penulis,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->stock
        ];
    }
}
