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
        // dd(request('kategori'));
        $buku = Buku::all();
        foreach ($buku as $item) {
            $tahun_terbit[] = $item->tahun_terbit;
        }
        return view('buku.buku', [
            'title' => 'Daftar Buku',
            'buku' => Buku::filter(request(['kategori', 'tahun_terbit']))->get(),
            'kategori' => Kategori_buku::all(),
            'tahun_terbit' => $tahun_terbit
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
            'judul' => ['required'], 'penulis' => 'required', 'penerbit' => 'required', 'tahun_terbit' => 'required', 'cover' => ['image', 'required'],
            'kategori' => 'required'
        ], [
            'cover.required' => 'Mohon isikan cover buku',
            'kategori.required' => 'Mohon isikan kategori buku'
        ]);
        // * membuat slug dari judul
        $slug = $validated['slug'] = Str::slug($validated['judul']);
        // * cek slug apakah ada yang sama jika ada maka tambahakan counter agar slug dapat bernilai unique
        $counter = 1;
        while (Buku::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['judul']) . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        $validated['cover'] = $request->file('cover')->store('cover-buku');
        $validated['kategori_buku_id'] = $request->input('kategori');
        Buku::create($validated);
        

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
            'kategori' => Kategori_buku::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $daftar_buku)
    {
        $validated = $request->validate(['judul' => ['required'], 'penulis' => 'required', 'penerbit' => 'required', 'tahun_terbit' => 'required',
            'cover' => ['image', 'required']
        ], [
            'cover.required' => 'Mohon isikan cover buku'
        ]);
        if ($daftar_buku->judul !== $validated['judul']) {

            $slug = $validated['slug'] = Str::slug($validated['judul']);

            $counter = 1;
            while (Buku::where('slug', $slug)->exists()) {
                $slug = Str::slug($validated['judul']) . '-' . $counter;
                $counter++;
            }
        }
        if ($daftar_buku->cover) {
            Storage::delete($daftar_buku->cover);
        } else {
            $validated['cover'] = $request->file('cover')->store('cover-buku');
        }

        $validated['slug'] = $slug;
        $daftar_buku->update($validated);
        return redirect()->route('daftar-buku.index')->with('success', 'Berhasil merubah data buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $daftar_buku)
    {
        $daftar_buku->delete();
        Storage::delete($daftar_buku->cover);
        return back()->with('success', 'Buku berhasil dihapus');
    }
}
