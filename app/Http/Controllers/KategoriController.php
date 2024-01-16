<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Kategori_buku;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('buku.kategori.kategori', [
            'title' => 'Daftar Kategori',
            'kategori' => Kategori_buku::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required'
        ]);
        $slug = $validated['slug'] = Str::slug($validated['nama']);

        $counter = 1;
        while (Kategori_buku::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['nama']) . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        Kategori_buku::create($validated);
        return redirect()->route('kategori-buku.index')->with('success', 'Berhasil menambah kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori_buku $kategori_buku)
    {
        $validated = $request->validate([
            'nama' => 'required'
        ]);
        $kategori_buku->update($validated);
        return redirect()->route('kategori-buku.index')->with('success', 'Berhasil merubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori_buku $kategori_buku)
    {
        $kategori_buku->delete();
        return back();
    }
}
