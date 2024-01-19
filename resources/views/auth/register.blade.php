@extends('layouts.templates.main')
@section('content-auth')
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                
                    <a href="{{ route('login.index') }}" class="logo d-flex align-items-center w-auto">
                      <img src="{{ asset('image/logo.png') }}" alt="">
                      <span class="d-none d-lg-block">Perpustakaan digital</span>
                    </a>
                  </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun</h5>
                    <p class="text-center small">Masukann data anda di bawah ini </p>
                  </div>

                  <form class="row g-3 "  action="{{ route('register.user') }}" method="POST">
                    @csrf
                    <div class="col-12">
                      <label for="yourName" class="form-label">Nama lengkap</label>
                      <input type="text" name="nama_lengkap" class="form-control" id="yourName" required name="nama_lengkap" required>
                      @error('nama_lengkap')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required name="email" required>
                      @error('email')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="yourUsername" required name="username" required>
                        @error('username')
                          <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required name="password">
                    </div>
                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Alamat</label>
                        <div class="input-group has-validation">
                          <textarea type="text" class="form-control" id="yourUsername" required name="alamat">
                            
                          </textarea>
                        </div>
                      </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Buat akun</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">sudah punya akun? <a href="{{ route('login.index') }}">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

             

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
@endsection