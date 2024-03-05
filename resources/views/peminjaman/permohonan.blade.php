@extends('layouts.templates.dashboard')
@section('content-dashboard')
<div class="card p-3">
    <p class="card-title mb-2">Filter</p>
    <form action="{{ route('daftar-permohonan.index') }}" method="GET">
        <div class="d-flex gap-3 justify-content-center mb-3 px-2">
            <div class="col-md-6">
                <select class="form-select petugas" name="petugas">
                    <option value="" selected disabled>-- Pilih Petugas --</option>
                   @foreach ($petugas as $item)
                       <option value="{{ $item->username }}">{{ $item->username }}</option>
                   @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select class="form-select status" name="status">
                    <option value="" selected disabled>-- Pilih Status --</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}> Disetujui
                    </option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}> Ditolak
                    </option>
                    <option value="Belum disetujui" {{ request('status') == 'Belum disetujui' ? 'selected' : '' }}> Belum disetujui</option>
                </select>
            </div>
        </div>


        <div class="text-center">
            <button class="btn btn-outline-primary">
                <i class="bi bi-filter"></i>
            </button>
            <div id="reset-filter" class="btn btn-outline-secondary"><i class="bi bi-arrow-repeat"></i></div>
        </div>
    </form>
</div>
    <div class="card">
        <div class="card-body pt-3">
          


            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Peminjam</th>
                        <th scope="col">Tanggal Pinjaman</th>
                        <th scope="col">Penanggung Jawab</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjam as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_peminjaman)->translatedFormat('d F Y') }}</td>
                            <td>
                                {{ $item->penanggung_jawab ?? '-' }}
                            </td>
                            <td>
                                @if ($item->status === 'Disetujui')
                                    <h6 class="badge bg-success">{{ $item->status }} </h6>
                                @elseif ($item->status === 'Ditolak')
                                    <h6 class="badge bg-danger">{{ $item->status }} </h6>
                                @else
                                    <h6 class="badge bg-warning">{{ $item->status }} </h6>
                                @endif
                            </td>
                            
                            
                            <td>
                                <div class="d-flex gap-3">
                                    @if ($item->status == 'Belum disetujui')
                                        <div>
                                            <form
                                                action="{{ route('daftar-permohonan.setuju', ['buku' => $item->buku->slug]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i>

                                                </button>
                                            </form>

                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-danger penolakan"
                                                data-slug ="{{ $item->buku->slug }}">
                                                <i class="bi bi-x-circle"></i>

                                            </button>
                                            <form
                                                action="{{ route('daftar-permohonan.penolakan', ['buku' => $item->buku->slug]) }}"
                                                hidden method="post" data-slug ="{{ $item->buku->slug }}"
                                                class="permohonanBukuForm">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                        </div>
                                    @elseif ($item->status == 'Disetujui')
                                        <div>
                                            <button class="btn btn-sm btn-danger penolakan"
                                                data-slug ="{{ $item->buku->slug }}">
                                                <i class="bi bi-x-circle"></i>

                                            </button>
                                            <form
                                                action="{{ route('daftar-permohonan.penolakan', ['buku' => $item->buku->slug]) }}"
                                                hidden method="post" data-slug ="{{ $item->buku->slug }}"
                                                class="permohonanBukuForm">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                        </div>
                                    @else
                                        <div>
                                            <form
                                                action="{{ route('daftar-permohonan.setuju', ['buku' => $item->buku->slug]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i>

                                                </button>
                                            </form>

                                        </div>
                                    @endif
                                   


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->

        </div>
    </div>

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
                        <label for="penerima" class="col-sm-4 col-md-6 mb-3 ">Permintaan Perpanjang <span
                                class="text-danger">*</span></label>

                        <div class="col-sm-10">
                            <input type="date" id="permintaan" placeholder="Masukan tanggal pengembalian"
                                class="form-control @error('perpanjang') is-invalid @enderror" name="perpanjang" required>
                            @error('perpanjang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <form id="tolakPerpanjang" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="keterangan" value="Permintaan perpanjang ditolak">
                        <button class="btn btn-danger">Tolak Permintaan</button>
                    </form>
                    <button type="button" class="btn btn-primary" id="submitperpanjang">Setujui Permintaan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.petugas').select2();
            $('.status').select2();
            $('.penolakan').click(function() {
                const buku = $(this).data('slug');
                console.log(buku);
                Swal.fire({
                    title: "Tolak Permohonan ? ",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Tolak permohonan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const permohonanBukuForm = $(`.permohonanBukuForm[data-slug="${buku}"]`);
                        permohonanBukuForm.submit()
                    }
                })

            });

            $('#ModalPerpanjang').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const slug = button.data('buku');

                // * setuju permintaan
                const permintaan = button.data('permintaan')
                $('#permintaan').val(permintaan);
                const form = $(this).find('form#perpanjangForm');
                const actionUrl = `/dashboard-perpustakaan/daftar-permohonan/${slug}/perpanjang`;
                form.attr('action', actionUrl);
                // tolak permintaan
                const form2 = $(this).find('form#tolakPerpanjang');
                const actionUrl2 = `/dashboard-perpustakaan/daftar-permohonan/${slug}/tolak-perpanjangan`;
                form2.attr('action', actionUrl2);

            });

            $('#submitperpanjang').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#perpanjangForm').submit(); // Submit form
            });
            $('#tolakPerpanjangan').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#tolakPerpanjang').submit(); // Submit form
            });
        })
    </script>
@endsection
