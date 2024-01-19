@extends('layouts.templates.dashboard')
@section('content-dashboard')
<div class="card p-2">
        <p class="card-title">Filter</p>
        <form class="row g-3" action="{{ route('daftar-buku.index') }}">
            <div class="col-md-6 ">
                <select class="form-select" aria-label="Default select example" name="kategori">
                    <option selected value="">Kategori</option>
                    @foreach ($kategori as $kategori)
                    <option value="{{ $kategori->nama }}" {{ (request('kategori') == $kategori->nama) ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3 ">
                <select class="form-select" aria-label="Default select example" name="tahun_terbit">
                    <option selected value="">Tahun terbit</option>
                    @foreach ($tahun_terbit as $item)
                    <option value="{{ $item }}" {{ (request('tahun_terbit') == $item) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter"></i>
                </button>
                <button type="reset" class="btn btn-secondary" id="reset-filter">
                    <i class="ri-arrow-go-back-fill"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body pt-3">

            <a href="{{ route('daftar-buku.create') }}" class="btn btn-outline-primary my-2">
                Tambah Buku
            </a>

            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->penerbit }}</td>
                            <td>{{ $item->tahun_terbit }}</td>
                            <td>
                                <div class="d-flex gap-3">

                                    <div>
                                        <a href="{{ route('daftar-buku.show', ['daftar_buku' => $item->slug]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('daftar-buku.edit', ['daftar_buku' => $item->slug]) }}"
                                            class="btn btn-sm btn-warning link-light">
                                            <i class='bi bi-pencil-square'></i>
                                        </a>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-danger link-light deleteBukuBtn"
                                            data-slug="{{ $item->slug }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        <form action="{{ route('daftar-buku.destroy', ['daftar_buku' => $item->slug]) }}"
                                            method="post" hidden class="deleteBukuForm" data-buku="{{ $item->slug }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>

                                    {{-- end admin-petugas --}}
                                    {{-- non -admin --}}
                                    

                                    {{-- end non -admin --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#reset-filter').click(function() {
                window.location.href =
                "{{ route('daftar-buku.index') }}"; // Arahkan ke URL awal tanpa query string
            });
            // delete buku
            $('.deleteBukuBtn').click(function() {
                const buku = $(this).data('slug');
                Swal.fire({
                    title: 'Anda yakin ?',
                    text: 'Anda tidak bisa mengambalikan data ini !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteBukuForm = $(`.deleteBukuForm[data-buku="${buku}"]`);
                        deleteBukuForm.submit();
                    }
                });
            })

            // pinjam buku
            $('.pinjamBukubtn').click(function() {
                const buku = $(this).data('buku');
                Swal.fire({
                    title: 'Anda yakin ?',
                    text: 'Buku yang dipinjam harus dikembalikan 7 hari setelah peminjaman !',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Pinjam buku'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const pinjamBukuForm = $(`.pinjamBukuForm[data-buku="${buku}"]`);
                        console.log(pinjamBukuForm);
                        pinjamBukuForm.submit();
                    }
                });
            })

        })
    </script>
@endsection
