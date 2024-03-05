<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori_buku;
use App\Models\Kategori_buku_relasi;
use App\Models\Ulasan_buku;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('buku.buku', [
            'title' => 'Daftar Buku',
            'buku' => Buku::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create-buku', [
            'title' => 'Tambah Buku',
            'kategori' => Kategori_buku::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required'],
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'stock' => 'required|numeric',
            'cover' => ['image', 'required']
        ], [
            'judul.requierd' => 'Judul harus di isi',
            'penulis.requierd' => 'penulis harus di isi',
            'penerbit.requierd' => 'penerbit harus di isi',
            'cover.required' => 'harus di isi',
            'cover.image' => 'cover harus berupa gambar',
            'tahun_terbit.numeric' => 'tahun terbit harus berisi nomor',
            'stock.required' => 'stock harus  di isi',
        ]);
        // ? membuat slug dari judul
        $slug = $validated['slug'] = Str::slug($validated['judul']);
        // ! cek slug apakah ada yang sama jika ada maka tambahakan counter agar slug dapat bernilai unique
        $counter = 1;
        while (Buku::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['judul']) . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        $validated['cover'] = $request->file('cover')->store('cover-buku');
        $buku = Buku::create($validated);
        $kategori = $request->kategori;
        if (!empty($kategori)) {
            foreach ($kategori as $kategori_id) {
                Kategori_buku_relasi::create(
                    [
                        'buku_id' => $buku->id,
                        'kategori_buku_id' => $kategori_id
                    ]
                );
            }
        }
       

        return redirect()->route('daftar-buku.index')->with('success', 'Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $daftar_buku)
    {
        $ulasan = Ulasan_buku::where('buku_id', $daftar_buku->id)->paginate(2);
        return view('buku.detail', [
            'title' => 'Detail Buku',
            'buku' => $daftar_buku,
            'ulasan' => $ulasan,
            'kategori' => Kategori_buku_relasi::where('buku_id', $daftar_buku->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $daftar_buku)
    {
        return view('buku.edit-buku', [
            'title' => 'Edit Buku',
            'buku' => $daftar_buku,
            'kategori' => Kategori_buku::all(),
            

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $daftar_buku)
    {
        $validated = $request->validate(['judul' => ['required'], 'penulis' => 'required', 'penerbit' => 'required', 'tahun_terbit' => 'required',
            'stock' => 'required|numeric',
        ], [
            'judul.requierd' => 'Judul harus di isi',
            'penulis.requierd' => 'penulis harus di isi',
            'penerbit.requierd' => 'penerbit harus di isi',
            'tahun_terbit.numeric' => 'tahun terbit harus berisi nomor',
            'stock.required' => 'stock harus  di isi',
        ]);
        if ($daftar_buku->judul !== $validated['judul']) {

            $slug = $validated['slug'] = Str::slug($validated['judul']);

            $counter = 1;
            while (Buku::where('slug', $slug)->exists()) {
                $slug = Str::slug($validated['judul']) . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }
        if ($request->file('cover')) {
            Storage::delete($daftar_buku->cover);
            $request->file('cover')->storeAs('cover-buku');
        }
        $kategori = $request->kategori;
        if (!empty($kategori)) {
            $daftar_buku->kategori()->detach();

            foreach ($kategori as $kategori_id) {
                $daftar_buku->kategori()->attach($kategori_id);
            }
        }
        $daftar_buku->update($validated);
        
        return redirect()->route('daftar-buku.index')->with('success', 'Berhasil merubah data buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $daftar_buku)
    {
        if ($daftar_buku->cover) {
            Storage::delete($daftar_buku->cover);
        }
        $daftar_buku->delete();
        return back()->with('success', 'Buku berhasil dihapus');
    }
}
