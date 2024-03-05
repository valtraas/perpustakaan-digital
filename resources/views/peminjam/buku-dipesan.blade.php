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
                        <th scope="col">Kategori</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->buku->penulis }}</td>
                            <td>  @foreach ($item->buku->kategori_buku_relasi as $kategori)
                                @if ($kategori->kategori->nama)
                                <span class="badge bg-secondary">{{ $kategori->kategori->nama }}</span>
                                    @else
                                    -
                                @endif
                                @endforeach</td>
                            <td>{{ $item->buku->tahun_terbit }}</td>
                            <td>
                                @if ($item->status == 'Belum disetujui')
                                <span class="badge bg-warning">
                                    {{ $item->status }}
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    {{ $item->status }}
                                </span>
                                @endif
                            </td>

                           
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <button class="btn btn-sm btn-danger batalPesanBtn"
                                            data-buku="{{ $item->buku->slug }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        <form action="{{ route('batal.pesan', ['buku' => $item->buku->slug]) }}"
                                            method="post" class="batalPesanForm" data-buku="{{ $item->buku->slug }}"
                                            hidden>
                                            @csrf
                                            @method('DELETE')
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
        $(document).ready(function() {
            $('.batalPesanBtn').click(function() {
                const buku = $(this).data('buku');
                const batalPesanForm = $(`.batalPesanForm[data-buku="${buku}"]`);
                Swal.fire({
                    title: 'Anda yakin ? ',
                    text: 'Buku akan di hapus dari permohonan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Batalkan permohonan'
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                        const batalPesanForm = $(`.batalPesanForm[data-buku="${buku}"]`);
                        batalPesanForm.submit()
                    }
                })

            });
        });
    </script>
@endsection
