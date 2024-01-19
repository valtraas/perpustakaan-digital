@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Buku {{ $buku->judul }}</h5>

            <!-- Horizontal Form -->
            <form action="{{ route('daftar-buku.update', ['daftar_buku' => $buku->slug]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="Judul-buku" class="col-sm-2 col-form-label">Judul Buku</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control " id="judul-buku" name="judul"
                            value="{{ $buku->judul }}" required>

                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penulis" name="penulis"
                            value="{{ $buku->penulis }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penerbit" name="penerbit"
                            value="{{ $buku->penerbit }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tahun-terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="tahun-terbit" min="0" name="tahun_terbit"
                            required value="{{ $buku->tahun_terbit }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-2 col-form-label">Cover Buku <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" id="formFile" name="cover">
                        @error('cover')
                            <small class="text-danger ">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example" name="kategori">
                            @foreach ($kategori as $item)
                                @if ($buku->kategori_buku_id === $item->id)
                                    <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                                @else
                                    <option value="" selected>Pilih kategori</option>
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center">
                    <a href="{{ route('daftar-buku.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form><!-- End Horizontal Form -->

    </div>
    </div>
@endsection
