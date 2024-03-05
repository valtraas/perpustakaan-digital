@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class=" mb-3">

        <form action="{{ route('laporan.export') }}" method="post">
            @csrf
            <button class="btn btn-outline-success">Eksport Excel</button>
        </form>
    

    </div>

    <div class="card mb-3">

        <div class="card-body pt-3">
            <!-- Table with stripped rows -->
            <form action="{{ route('laporan.all') }}" method="GET">
                <div class="d-flex gap-3 justify-content-center mb-3 px-2">
                    <div class="col-md-2">
                        <select class="form-select petugas" name="penulis">
                            <option value="" selected disabled>-- Pilih Penulis --</option>
                           @foreach ($buku as $item)
                               <option value="{{ $item->penulis }}">{{ $item->penulis }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select kategori-filter" name="kategori[]" multiple="multiple">
                            @foreach ($kategori as $item)
                           
                               <option value="{{ $item->id }}">{{ $item->nama }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select status" name="penerbit">
                            <option value="" selected disabled>-- Pilih Penerbit --</option>
                            @foreach ($buku as $item)
                               <option value="{{ $item->penerbit }}">{{ $item->penerbit }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select status" name="tahun_terbit">
                            <option value="" selected disabled>-- Pilih Tahun Terbit --</option>
                            @foreach ($buku as $item)
                               <option value="{{ $item->tahun_terbit }}">{{ $item->tahun_terbit }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select status" name="status">
                            <option value="" selected disabled>-- Pilih Stock --</option>
                               <option value="0">Stock Habis</option>
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
            <table class="table datatable table-responsive ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>
                                @forelse ($item->kategori_buku_relasi as $kategori)
                                    <span class="badge bg-secondary">{{ $kategori->kategori->nama }}</span>

                                    @empty
                                    -
                                @endforelse
                            </td>
                            <td>{{ $item->penerbit }}</td>
                            <td>
                                {{$item->tahun_terbit}}
                            </td>
                            <td>
                            @if ($item->stock == 0 )
                                <span class="badge bg-danger">Stock Habis</span>
                            @else
                            {{$item->stock}}
                            @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->

        </div>
    </div>
    <div class="card mb-3">

        <div class="card-body pt-3">
            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Peminjam</th>
                        <th scope="col">Tanggal Pinjaman</th>
                        <th scope="col">Tanggal Pengembalian</th>
                        <th scope="col">Penanggung Jawab</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjam as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_peminjaman)->translatedFormat('d F Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_pengembalian)->translatedFormat('d F Y') }}</td>
                            <td>{{ $item->penanggung_jawab }}</td>
                            <td>
                                @if ($item->keterangan)
                                @if ($item->keterangan !== 'Perpanjangan Disetujui' && $item->keterangan !== 'Perpanjangan ditolak')
                                    <span class="badge bg-info">
                                        {{ $item->keterangan }}
                                    </span>
                                @elseif ($item->keterangan == 'Perpanjangan Disetujui')
                                    <span class="badge bg-success">
                                        {{ $item->keterangan }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ $item->keterangan }}
                                    </span>
                                @endif
                            @else
                                -
                            @endif
                            <td>
                                @if ($item->status === 'Belum disetujui')
                                    <h6 class="badge bg-warning">{{ $item->status }} </h6>
                                @elseif ($item->status === 'Ditolak')
                                    <h6 class="badge bg-danger">{{ $item->status }} </h6>
                                @else
                                    <h6 class="badge bg-success">{{ $item->status }} </h6>
                                @endif
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
                "{{ route('laporan.all') }}"; // Arahkan ke URL awal tanpa query string
            });
            $('.kategori-filter').select2();
        });
    </script>
@endsection
