<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard | {{ $title }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('image/logo.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href=" {{ asset('vendor/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href=" {{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href=" {{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href=" {{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href=" {{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href=" {{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    {{-- script --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <main class="px-4 pt-2">
        <div class="mb-5">
            <img src="{{ asset('image/logo.png') }}" alt="" class="d-block mx-auto img-fluid" width="100">
            <h1 class="card-title text-center fs-2">Perpustakaan Digital</h1>
        </div>

        {{-- total data --}}
        <div class="table-responsive-md mb-3 w-50 mx-auto">
            <table class="table table-light table-bordered w-full">
                <tbody>
                        <tr class="">
                            <td scope="row">Total peminjam</td>
                            <td>{{ $peminjam->count() }}</td>
                        </tr>
                        <tr class="">
                            <td scope="row">Total buku yang sudah dikembalikan</td>
                            <td>{{ $dikembalikan->count() }}</td>
                        </tr>
                        <tr class="">
                            <td scope="row">Total yang belum dikembalikan</td>
                            <td>{{ $belum_dikembalikan->count() }}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    {{-- end total data --}}
       
        {{-- peminjam table --}}
        <div class="peminjam-table">
            <h1 class="card-title text-center fs-2">Daftar Peminjam</h1>

            <div class="table-responsive-md">
                <table class="table table-light table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">Peminjam</th>
                            <th scope="col">Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjam as $item)
                            <tr class="">
                                <td>{{ $item->user->username }}</td>
                                <td>{{ $item->buku->judul }}</td>
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
                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
        </div>
        {{-- end peminjam table --}}



    </main><!-- End #main -->

    <script>
        window.print()
    </script>

</body>

</html>
