@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{ asset('storage/' . $buku->cover) }}" alt="Profile" class="rounded-2 my-2" width="200">
                    <div class="text-center">
                        <h3>{{ $buku->judul }}</h3>
                        <h6>{{ $buku->penulis }}</h6>
                        <h6>{{ $buku->penerbit }}</h6>
                        <h6>{{ $buku->tahun_terbit }}</h6>
                        <div class="d-md-flex flex-md-wrap gap-2">
                            @foreach ($kategori as $item)
                                <span class="badge bg-secondary">{{ $item->kategori->nama }}</span>
                            @endforeach
                        </div>
                    </div>


                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <p class="text-center fs-3 card-title">Ulasan</p>
                    <div class="row mt-4">
                        @forelse ($ulasan as $ulas)
                            <div class="col-xxl-12 col-md-12">
                                <div class="card info-card rating-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-4">
                                            <img src="{{ asset('image/smk.png') }}" alt="Profile" class=""
                                                width="35" height="35">
                                            <h5 class="card-title">{{ $ulas->users->username }} </h5>
                                            @if ($ulas->users->username === auth()->user()->username)
                                                <div>
                                                    <button class="btn btn-sm btn-danger link-light deleteUlasanbtn"
                                                        data-ulasan="{{ $ulas->id }}">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                    <form action="{{ route('delte.ulasan', ['ulasan_buku' => $ulas->id]) }}"
                                                        method="post" hidden class="ulasanForm"
                                                        data-ulasan="{{ $ulas->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bxs-star"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $ulas->rating }}/5</h6>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p>{{ $ulas->ulasan }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Revenue Card -->
                        @empty
                            <p class="card-title fs-3 text-center my-5">Belum ada ulasan</p>
                        @endforelse
                    </div>


                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            // delete buku
            // $('.deleteUlasanbtn').click(function() {
            //     const ulasan = $(this).data('ulasan');
            //     console.log(ulasan);
            //     Swal.fire({
            //         title: 'Anda yakin ?',
            //         text: 'Anda tidak bisa mengambalikan data ini !',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Ya, hapus!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             const deleteUlasanForm = $(`.deleteUlasanForm[data-ulasan="${ulasan}"]`);
            //             // console.log(deleteBukuForm);
            //             deleteUlasanForm.submit();
            //         }
            //     });
            // })
            $('.deleteUlasanbtn').click(function() {
                const ulasan = $(this).data('ulasan');
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
                        const deleteUlasanForm = $(`.ulasanForm[data-ulasan="${ulasan}"]`);
                        deleteUlasanForm.submit();
                    }
                });
            })

        })
    </script>
@endsection
