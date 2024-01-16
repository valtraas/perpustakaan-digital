@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="card">
        <div>
            {{ session('Warning') }}
        </div>
        <div class="card-body pt-3">
            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Tanggal Pengembalian</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->tgl_peminjaman }}</td>
                            <td>{{ $item->tgl_pengembalian }}</td>
                            <td>
                                @if ($item->status === 'Belum Dikembalikan')
                                    <h6 class="badge bg-warning">{{ $item->status }} </h6>
                                @else
                                    <h6 class="badge bg-success">{{ $item->status }} </h6>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <button class="btn btn-sm btn-info link-light" data-bs-toggle="modal"
                                            data-bs-target="#ModalPerpanjang" data-bs-trigger="click"
                                            data-buku='{{ $item->id }}'>
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <div>
                                        @if (!auth()->user()->koleksi->contains('buku_id', $item->buku->id))
                                            <form action="{{ route('peminjam.koleksi') }}" method="post"
                                                class="koleksiBukuForm" data-buku="{{ $item->buku->slug }}">
                                                @csrf
                                                <input type="hidden" value="{{ auth()->user()->id }}" name="user">
                                                <input type="hidden" value="{{ $item->buku->id }}" name="buku">
                                                <button class="btn btn-sm btn-warning link-light "
                                                    data-buku="{{ $item->buku->slug }}">
                                                    <i class="bi bi-bookmark-fill"></i>

                                                </button>
                                            </form>
                                        @else
                                            <div class="btn btn-sm btn-success link-light "
                                                title="Sudah ditambahkan ke koleksi">
                                                <i class="bi bi-bookmark-check-fill"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        {{-- <button class="btn btn-sm btn-info link-light" data-bs-toggle="modal"
                                            data-bs-target="#ModalPengembalian" data-bs-trigger="click"
                                            data-slug='{{ $item->buku->slug }}' data-judul="{{ $item->buku->judul }}"
                                            data-buku="{{ $item->buku->id }}">
                                            <i class="ri-arrow-go-back-fill"></i>
                                        </button> --}}
                                        <button class="btn btn-sm btn-danger link-light PengembalianBukuBtn"
                                            data-slug='{{ $item->buku->slug }}' data-judul="{{ $item->buku->judul }}"
                                            data-pinjam="{{ $item->id }}">
                                            <i class="ri-arrow-go-back-fill"></i>
                                        </button>
                                        <form
                                            action="{{ route('daftar-buku-pinjaman.destroy', ['daftar_buku_pinjaman' => $item->id]) }}"
                                            method="post" hidden class="deleteBukuForm" data-pinjam="{{ $item->id }}">
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


    {{-- modal-perpanjang --}}
    <div class="modal fade" id="ModalPerpanjang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Perpanjang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="perpanjangForm" method="post">
                        @csrf
                        @method('PUT')
                        <label for="penerima" class="col-sm-2 col-form-label">Tanggal pengembalian<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="date" id="penerima" placeholder="Masukan tanggal pengembalian"
                                class="form-control @error('tgl_pengembalian') is-invalid @enderror" name="tgl_pengembalian"
                                required>
                            @error('tgl_pengembalian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitperpanjang">Perpanjang</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end-modal-create --}}

    {{-- modal pengembalian --}}
    <div class="modal fade" id="ModalPengembalian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ulas Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="PengembalianBuku" method="post">
                        @csrf
                        <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="buku"id='buku'>
                        <label for="penerima" class="col-sm-2 col-form-label">Buku<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10 mb-3">
                            <input type="text" id="judul" class="form-control " disabled>
                        </div>
                        <label for="rating" class="col-sm-2 col-form-label">Rating<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10 mb-3">
                            <input type="number" min="0" max="5" id="rating"
                                placeholder="Masukan rating buku 1-5"
                                class="form-control @error('rating') is-invalid @enderror" name="rating" required>
                            @error('rating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <label for="ulasan" class="col-sm-2 col-form-label">Ulasan<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10 mb-3">
                            <textarea id="ulasan" class="form-control @error('ulasan') is-invalid @enderror" name="ulasan" required> 
                            </textarea>
                            @error('ulasan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitPengembalian">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal ulasan --}}

    <script>
        $(document).ready(function() {
            @if (session()->has('warning'))
                const buku = "{!! session('warning') !!}";
                Swal.fire({
                    title: 'warning !',
                    html : `<p>Masa peminjaman ${buku} buku telah habis.</p>
                    <p> Buku akan <span class="text-danger fw-bold">dikembalikan</span>  secara otomatis dalam 1 jam.</p>
                    `,
                    icon: 'info',
                  
                });
            @endif
            // pengembalian buku 
            $('.PengembalianBukuBtn').click(function() {
                const button = $(this);
                const buku = button.data('pinjam');
                const judul = button.data('judul');

                Swal.fire({
                    title: 'Anda yakin ?',
                    text: 'Anda tidak bisa mengembalikan data ini !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Pengembalian(judul, buku)
                    }
                });
            });

            function Pengembalian(judul, buku) {
                $('#ModalPengembalian').modal('show');

                $('#buku').val(buku);
                $('#judul').val(judul);

                $('#rating').on('keyup', function() {
                    const rating = $(this).val();
                    const valid = rating >= 0 && rating <= 5;
                    if (!valid) {
                        $(this).val(rating.slice(0, -1));
                    }
                });

                const form = $('#ModalPengembalian').find('form#PengembalianBuku');
                const actionUrl =
                    `/dashboard-perpustakaan/daftar-buku-pinjaman/pengembalian/${buku}`;
                form.attr('action', actionUrl);

                // Definisikan deleteBukuForm di luar event handler
                const deleteBukuForm = $(`.deleteBukuForm[data-buku="${buku}"]`);

                $('#submitPengembalian').off('click');
                $('#submitPengembalian').on('click', function() {
                    $('#PengembalianBuku').off('submit');
                    // Ulasan terkirim, lanjutkan dengan menghapus buku
                    // Ulasan terkirim, lanjutkan dengan menghapus buku
                    $('#PengembalianBuku').submit(); // Submit form

                });

                $('#ModalPengembalian').on('hidden.bs.modal', function() {
                    // Menggantikan 'deleteBukuForm' dengan sesuai dengan kebutuhan Anda
                    deleteBukuForm.submit();
                });
            }


            // end pengembalian buku 
            // ulasan
            // $('#ModalPengembalian').on('show.bs.modal', function(event) {
            //     const button = $(event.relatedTarget);
            //     const buku = button.data('buku')
            //     const judul = button.data('judul')
            //     $('#buku').val(buku)
            //     $('#judul').val(judul);
            //     $('#rating').on('keyup', function() {
            //         const rating = $(this).val()
            //         const valid = rating >= 0 && rating <= 5;
            //         if (!valid) {
            //             $(this).val(rating.slice(0, -1))
            //         }
            //     })
            //     const form = $(this).find('form#PengembalianBuku');
            //     const actionUrl = `/dashboard-perpustakaan/ulas-buku`;
            //     form.attr('action', actionUrl);
            // });

            // $('#submitPengembalian').on('click', function() {
            //     console.log('halo');
            //     // Lakukan sesuatu jika tombol 'Simpan' diklik
            //     $('#PengembalianBuku').submit(); // Submit form
            // });
            // end ulasan
            // /dashboard-perpustakaan/daftar-buku-pinjaman/4
            // /dashboard-perpustakaan/daftar-buku-pinjaman/3



            // modal Edit
            $('#ModalPerpanjang').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const slug = button.data('buku');
                const form = $(this).find('form#perpanjangForm');
                const actionUrl = `/dashboard-perpustakaan/daftar-buku-pinjaman/${slug}`;
                form.attr('action', actionUrl);
            });

            $('#submitperpanjang').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#perpanjangForm').submit(); // Submit form
            });
            // end modal Edit
        });
    </script>
@endsection
