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
                                        <a href="{{ route('peminjam.detail', ['buku' => $item->slug]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    <div>
                                        @if (!auth()->user()->peminjam->contains('buku_id',$item->id))
                                             <button class="btn btn-sm btn-success link-light pinjamBukubtn"
                                            data-buku="{{ $item->slug }}">
                                            <i class="bi bi-journal-arrow-down"></i>
                                        </button>
                                        <form action="{{ route('pinjam-buku.store') }}" method="post" hidden
                                            class="pinjamBukuForm" data-buku="{{ $item->slug }}">
                                            @csrf
                                            <input type="hidden" value="{{ auth()->user()->id }}" name="peminjam">
                                            <input type="hidden" value="{{ $item->id }}" name="buku">
                                        </form>
                                        @else
                                        <div class="btn btn-sm btn-danger link-light " title="Sudah dipinjam">
                                            <i class="bi bi-journal-x"></i>
                                       </div>
                                        @endif
                                       
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-info link-light" data-bs-toggle="modal"
                                            data-bs-target="#ModalUlasan" data-bs-trigger="click"
                                            data-slug='{{ $item->slug }}' data-judul="{{ $item->judul }}"
                                            data-buku="{{ $item->id }}">
                                            <i class="bi bi-chat-text"></i>
                                        </button>
                                    </div>
                                    <div>
                                        @if (!auth()->user()->koleksi->contains('buku_id', $item->id))
                                            
                                    <form action="{{route('peminjam.koleksi') }}" method="post" 
                                        class="koleksiBukuForm" data-buku="{{ $item->slug }}">
                                        @csrf
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="user">
                                        <input type="hidden" value="{{ $item->id }}" name="buku">
                                        <button class="btn btn-sm btn-warning link-light "
                                        data-buku="{{ $item->slug }}">
                                        <i class="bi bi-bookmark-fill"></i>

                                    </button>
                                    </form>

                                    @else
                                    <div class="btn btn-sm btn-success link-light " title="Sudah ditambahkan ke koleksi">
                                         <i class="bi bi-bookmark-check-fill"></i>
                                    </div>
                                   
                                        @endif
                                      
                                    </div>

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


    {{-- modal-create --}}
    <div class="modal fade" id="ModalUlasan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ulas Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="UlasanBuku" method="post">
                        @csrf
                        <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="buku"id='buku'>
                        <label for="penerima" class="col-sm-2 col-form-label">Buku<span class="text-danger">*</span></label>
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
                    <button type="button" class="btn btn-primary" id="ulasanBukuSubmit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end-modal-create --}}

    <script>
        $(document).ready(function() {
            // modal create
            $('#ModalUlasan').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const buku = button.data('buku')
                const judul = button.data('judul')
                $('#buku').val(buku)
                $('#judul').val(judul);
                $('#rating').on('keyup', function() {
                    const rating = $(this).val()
                    const valid = rating >= 0 && rating <= 5;
                    if (!valid) {
                        $(this).val(rating.slice(0, -1))
                    }
                })
                const form = $(this).find('form#UlasanBuku');
                const actionUrl = `/dashboard-perpustakaan/ulas-buku`;
                form.attr('action', actionUrl);


            });

            $('#ulasanBukuSubmit').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#UlasanBuku').submit(); // Submit form
            });


            // end modal create



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
