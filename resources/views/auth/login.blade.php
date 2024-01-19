@extends('layouts.templates.main')
@section('content-auth')
    <main>
      
      <div class="container">
        
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-octagon me-1"></i>
                           {{session('error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle me-1"></i>
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('login.index') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('image/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">Perpustakaan digital</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login </h5>
                                        <p class="text-center small">Masukan username & password </p>
                                    </div>

                                    <form class="row g-3" action="{{ route('login.auth') }}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group ">
                                                <input type="text" name="username" class="form-control" id="yourUsername"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword"
                                                required>
                                        </div>


                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Belum punya akun? <a
                                                    href="{{ route('register.index') }}">buat akun baru</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>


                        </div>

                    </div>
                </div>
        </div>

        </section>

        </div>
    </main><!-- End #main -->
    
@endsection
