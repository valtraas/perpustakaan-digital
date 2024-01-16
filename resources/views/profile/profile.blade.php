@extends('layouts.templates.dashboard')
@section('content-dashboard')
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if (auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="rounded-circle w-25">
                    @else
                        <img src="{{ asset('image/profile.png') }}" alt="Profile" class="rounded-circle mb-3" width="100">
                    @endif
                    <h3>{{ auth()->user()->username }}</h3>
                    <h4>{{ auth()->user()->roles->nama }}</h4>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Detail</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Profile Details</h5>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->nama_lengkap }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Username</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->username }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Role</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->roles->nama }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->alamat }}</div>
                            </div>



                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="{{ route('profile.update', ['user' => auth()->user()->username]) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Photo Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        @if (auth()->user()->photo)
                                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile"
                                                class="rounded-circle w-25">
                                        @else
                                            <img src="{{ asset('image/profile.png') }}" alt="Profile"
                                                class="rounded-circle mb-3" width="100">
                                        @endif
                                        <div class="pt-2">
                                            <a href="#" class="btn btn-primary btn-sm"
                                                title="Upload new profile image"
                                                onclick="document.getElementById('fileInput').click(); return false;">
                                                <i class="bi bi-upload"></i>
                                            </a>
                                            <input type="file" id="fileInput" class="d-none" name="photo">
                                            <div class="btn btn-danger btn-sm" title="Hapus photo profile" id="deletePhoto"
                                                data-user="{{ auth()->user()->username }}"><i class="bi bi-trash"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-8 col-lg-9">

                                        <input name="nama_lengkap" type="text" class="form-control" id="fullName"
                                            value="{{ auth()->user()->nama_lengkap }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="username" type="text" class="form-control" id="username"
                                            value="{{ auth()->user()->username }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="text" class="form-control" id="email"
                                            value="{{ auth()->user()->email }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="alamat" type="text" class="form-control" id="alamat"
                                            value="{{ auth()->user()->alamat }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form><!-- End Profile Edit Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#deletePhoto').click(function() {
                const user = $(this).data('user');
                const csrf = "{{ csrf_token() }} "
                $.ajax({
                    type: "post",
                    url: `/dashboard-perpustakaan/profile/${user}/delete-photo`,
                    data: {
                        _token: csrf
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil menghapus photo profile',
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        })
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menghapus photo',
                            icon: 'error'
                        })
                    }
                });
            });
        });
    </script>
@endsection
