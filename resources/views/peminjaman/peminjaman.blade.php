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
                    <th scope="col">Peminjam</th>
                    <th scope="col">Tanggal Pinjaman</th>
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
                        <td>{{ $item->tgl_peminjaman }}</td>
                        <td>
                        @if ($item->status === 'Belum Dikembalikan')
                        <h6 class="badge bg-warning">{{ $item->status }} </h6>
                        @elseif ($item->status === 'Denda')
                        <h6 class="badge bg-danger">{{ $item->status }} </h6>
                        @else
                        <h6 class="badge bg-success">{{ $item->status }} </h6>
                        @endif
                        </td>
                        <td>
                            <div class="d-flex gap-3">
                                <div>
                                    <a href="{{ route('daftar-peminjam.detail',['buku'=>$item->buku->slug]) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
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
        
    })
</script>
@endsection