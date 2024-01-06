@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Tambah Buku</h5>

            <!-- Horizontal Form -->
            <form action="{{ route('daftar-buku.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="Judul-buku" class="col-sm-2 col-form-label">Judul Buku</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="judul-buku" name="judul">
                       
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penulis" name="penulis">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penerbit" name="penerbit">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tahun-terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="tahun-terbit" min="0" name="tahun_terbit" required>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('daftar-buku.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form><!-- End Horizontal Form -->

        </div>
    </div>
@endsection
