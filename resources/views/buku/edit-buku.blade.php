@extends('layouts.templates.dashboard')
@section('content-dashboard')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Buku {{ $buku->judul }}</h5>

      <!-- Horizontal Form -->
      <form action="{{ route('daftar-buku.update',['daftar_buku'=>$buku->slug]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <label for="Judul-buku" class="col-sm-2 col-form-label">Judul Buku <span
                    class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control " id="judul-buku" name="judul" value="{{ $buku->judul }}" required>
               
            </div>
        </div>
        <div class="row mb-3">
            <label for="penulis" class="col-sm-2 col-form-label">Penulis <span
                    class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="penulis" name="penulis"  value="{{ $buku->penulis }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="penerbit" class="col-sm-2 col-form-label">Penerbit <span
                    class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $buku->penerbit }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="tahun-terbit" class="col-sm-2 col-form-label">Tahun Terbit <span
                    class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="tahun-terbit" min="0" name="tahun_terbit" required value="{{ $buku->tahun_terbit }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="tahun-terbit" class="col-sm-2 col-form-label">Stock <span
                    class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" min="0" name="stock" required value="{{ $buku->stock }}">
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
            <label for="" class="col-sm-2 col-form-label">Kategori</label>
            
            <div class="col-sm-10">
                <select class=" select2 form-select " name="kategori[]" multiple="multiple" aria-placeholder="kkk">
                    @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" {{ in_array($item->id, $buku->kategori_buku_relasi->pluck('kategori_buku_id')->toArray()) ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
                  </select>

            </div>
            

        </div>
        <div class="text-center">
            <a href="{{ route('daftar-buku.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form><!-- End Horizontal Form -->

    </div>
  </div>
<script>
   $(document).ready(function() {
            $('#stock').on('keyup', function() {
                let stock = $("#stock").val()
                if (stock < 0) {
                    $('#stock').val(0)
                }
            });

            $('.select2').select2();
            
        });
</script>
@endsection