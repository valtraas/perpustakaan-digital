@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="card">
        <div class="card-body pt-3">

            <button class="btn btn-outline-primary my-2" data-bs-toggle="modal" data-bs-target="#ModalKategoriCreate"
                data-bs-trigger="click">
                Tambah Kategori
            </button>

            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <button class="btn btn-sm btn-warning link-light" data-bs-toggle="modal"
                                            data-bs-target="#ModalKategoriEdit" data-bs-trigger="click" data-slug='{{ $item->slug }}' data-kategori="{{ $item->nama }}">
                                            <i class='bi bi-pencil-square'></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-danger link-light deletekategoriBtn"
                                            data-slug="{{ $item->slug }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        <form
                                            action="{{ route('kategori-buku.destroy', ['kategori_buku' => $item->slug]) }}"
                                            method="post" hidden class="deletekategoriForm"
                                            data-kategori="{{ $item->slug }}">
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

    {{-- modal --}}

    {{-- modal-create --}}
    <div class="modal fade" id="ModalKategoriCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="kategoriFormCreate" method="post">
                        @csrf
                        <label for="penerima" class="col-sm-2 col-form-label">Nama<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="penerima" placeholder="Masukan nama kategori"
                                class="form-control @error('nama') is-invalid @enderror" name="nama" required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitKategoriCreate">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end-modal-create --}}
    {{-- modal-edit --}}
    <div class="modal fade" id="ModalKategoriEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="kategoriFormEdit" method="post">
                    @method('PUT')
                    @csrf
                    <label for="kategori-edit" class="col-sm-2 col-form-label" id="kategoriEdit">Nama<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" id="kategori-edit" placeholder="Masukan nama kategori"
                            class="form-control @error('nama') is-invalid @enderror" name="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitKategoriEdit">Simpan</button>
            </div>
        </div>
    </div>
</div>
    {{-- end-modal-edit --}}

    <script>
        $(document).ready(function() {
            // modal create
            $('#ModalKategoriCreate').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const form = $(this).find('form#kategoriFormCreate');
                const actionUrl = `/dashboard-perpustakaan/kategori-buku`;
                form.attr('action', actionUrl);
            });

            $('#submitKategoriCreate').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#kategoriFormCreate').submit(); // Submit form
            });
            // end modal create
            // modal Edit
            $('#ModalKategoriEdit').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const slug = button.data('slug');
                const kategori = button.data('kategori')
                console.log(kategori);
                $('#kategori-edit').val(kategori);
                const form = $(this).find('form#kategoriFormEdit');
                const actionUrl = `/dashboard-perpustakaan/kategori-buku/${slug}`;
                form.attr('action', actionUrl);
            });

            $('#submitKategoriEdit').on('click', function() {
                // Lakukan sesuatu jika tombol 'Simpan' diklik
                $('#kategoriFormEdit').submit(); // Submit form
            });
            // end modal Edit


            // modal delete
            $('.deletekategoriBtn').click(function() {
                const kategori = $(this).data('slug');
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
                        const deletekategoriForm = $(
                            `.deletekategoriForm[data-kategori="${kategori}"]`);
                        deletekategoriForm.submit();
                    }
                });
            })

        })
    </script>
@endsection
