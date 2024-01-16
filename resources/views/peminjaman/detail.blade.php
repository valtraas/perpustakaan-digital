@extends('layouts.templates.dashboard')
@section('content-dashboard')
<div class="row">
    <div class="col-xl-4">

        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <img src="{{ asset('image/smk.png') }}" alt="Profile" class="rounded-circle my-2" width="200">
                <h3>{{ $peminjam->buku->judul }}</h3>
                @if ($peminjam->status === 'Belum Dikembalikan')
                <h6 class="badge bg-warning">{{ $peminjam->status }} </h6>
                @elseif ($peminjam->status === 'Denda')
                <h6 class="badge bg-danger">{{ $peminjam->status }} </h6>
                @else
                <h6 class="badge bg-success">{{ $peminjam->status }} </h6>
                @endif
            </div>
        </div>

    </div>

    <div class="col-xl-8">

        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <div class="row">
                    <div class="col-xxl-12 col-md-12">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">          
                            <h5 class="card-title">Detail Pinjaman</h5>
          
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="fullName" type="text" class="form-control" id="fullName" value="{{ $peminjam->user->nama_lengkap }}" disabled>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="fullName" type="text" class="form-control" id="fullName" value="{{ $peminjam->user->username }}" disabled>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="fullName" type="text" class="form-control" id="fullName" value="{{ $peminjam->user->email }}" disabled>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                <div class="col-md-8 col-lg-9">
                                  <textarea name="fullName"  class="form-control" id="fullName" disabled>
{{ $peminjam->user->alamat }}
                                  </textarea>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tanggal Pinjam</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="fullName" type="text" class="form-control" id="fullName" value="{{ $peminjam->tgl_peminjaman }}" disabled>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tanggal Pengembalian</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="fullName" type="text" class="form-control" id="fullName" value="{{ $peminjam->tgl_pengembalian }}" disabled>
                                </div>
                              </div>
                             <a href="{{ route('daftar-peminjam.index') }}" class="btn btn-secondary">Kembali</a>
                          </div>
                    </div><!-- End Revenue Card -->
                </div>
           

            </div>
        </div>

    </div>
</div>
@endsection
