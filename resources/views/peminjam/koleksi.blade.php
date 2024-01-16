
@extends('layouts.templates.dashboard')
@section('content-dashboard')
<div class="card">
    <div class="card-body pt-3">
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
                @foreach ($koleksi as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->buku->penulis }}</td>
                        <td>{{ $item->buku->penerbit }}</td>
                        <td>{{ $item->buku->tahun_terbit }}</td>
                        <td>
                            <div class="d-flex gap-3">

                                <div>
                                    <a href="{{ route('koleksi.detail', ['koleksi' => $item->buku->id]) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-danger link-light deleteBukuBtn"
                                        data-buku="{{ $item->buku->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    <form action="{{ route('koleksi.destroy', ['koleksi_pribadi' => $item->buku->id]) }}"
                                        method="post" hidden class="deleteBukuForm" data-buku="{{ $item->buku->id }}">
                                        @csrf
                                    </form>
                                </div>

                               
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
    $('.deleteBukuBtn').click(function() {
                const buku = $(this).data('buku');
                Swal.fire({
                    title: 'Anda yakin ?',
                    text: 'Buku ini akan dihapus dari koleksi anda !',
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
</script>
@endsection