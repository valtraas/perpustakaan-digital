<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BukuSheets implements FromCollection, WithHeadings, WithMapping, WithTitle
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
    public function title(): string
    {
        return 'Buku';
    }
    public function headings(): array
    {
        return [
            'Judul',
            'Penulis',
            'Penerbit',
            'Tahun Terbit',
            'Stock',
            'Kategori',
        ];
    }

    public function collection()
    {
        $query = Buku::query();
        // dd($this->kategori);

        if ($this->penulis !== null) {
            $query->where('penulis', $this->penulis);
        }

        if ($this->tahun_terbit !== null) {
            $query->where('tahun_terbit', $this->tahun_terbit);
        }
        if (!empty($this->kategori)) {
            $query->whereHas('kategori_buku_relasi', function ($query) {
                $query->whereIn('kategori_buku_id', $this->kategori);
            }, '=', count($this->kategori));
        }

        // dd($query->get());
        // Jika ketiga variabel kosong, kembalikan semua data
        if ($this->penulis === null && $this->tahun_terbit === null && empty($this->kategori)) {
            return Buku::all();
        }
        return $query->get();
    }
    public function map($buku): array
    {
        $kategori = [];

        foreach ($buku->kategori_buku_relasi as $kategori_buku_relasi) {
            $kategori[] = $kategori_buku_relasi->kategori->nama;
        }

        return [
            $buku->judul,
            $buku->penulis,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->stock,
            implode(', ', $kategori)
        ];
    }
}
