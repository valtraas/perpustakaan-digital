@extends('layouts.templates.dashboard')
@section('content-dashboard')
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
                        <th scope="col">Kategori</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>
                                @foreach ($item->kategori_buku_relasi as $kategori)
                                @if ($kategori->kategori->nama)
                                <span class="badge bg-secondary">{{ $kategori->kategori->nama }}</span>
                                    @else
                                    -
                                @endif
                                @endforeach
                            </td>
                            <td>{{ $item->stock }}</td>
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
