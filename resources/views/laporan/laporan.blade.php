@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="dropdown mb-3">

        <a href="{{ route('laporan.print') }}" target="_blank" class="btn btn-outline-success ">
            Generate laporan
        </a>

    </div>

    <div class="card p-2">
        <p class="card-title">Filter</p>
        <form class="row g-3" action="{{ route('laporan.all') }}">
            <div class="col-md-6">
                <input type="date" class="form-control filter_laporan" name="tgl_peminjaman"
                    value="{{ request('tgl_peminjaman') }}">
            </div>
            <div class="col-md-6">
                <input type="date" class="form-control filter_laporan" name="tgl_pengembalian"
                    value="{{ request('tgl_pengmbalian') }}">
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
            <!-- Table with stripped rows -->
            <table class="table datatable ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Peminjam</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Tanggal Pinjaman</th>
                        <th scope="col">Tanggal Pengembalian</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjam as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ $item->tgl_peminjaman }}</td>
                            <td>{{ $item->tgl_pengembalian }}</td>
                            <td>
                                @if ($item->status === 'Belum Dikembalikan')
                                    <h6 class="badge bg-warning">{{ $item->status }} </h6>
                                @elseif ($item->status === 'Denda')
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
        });
    </script>
@endsection
