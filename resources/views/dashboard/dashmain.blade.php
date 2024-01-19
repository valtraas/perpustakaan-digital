@extends('layouts.templates.dashboard')
@section('content-dashboard')
<section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Buku </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bxs-book"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $buku->count() }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->
@can('admin-petugas')
    <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-4">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Kategori Buku </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bx bxs-category-alt"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $kategori->count() }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-md-4">

            <div class="card info-card customers-card">

              <div class="card-body">
                <h5 class="card-title">Peminjam </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-contacts-book-2-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $peminjam->count() }}</h6>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->
@endcan
@can('peminjam')
     <!-- Revenue Card -->
     <div class="col-xxl-4 col-md-4">
      <div class="card info-card revenue-card">

        <div class="card-body">
          <h5 class="card-title">Koleksi Buku </h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $koleksi->count() }}</h6>
            </div>
          </div>
        </div>

      </div>
    </div><!-- End Revenue Card -->

    <!-- Customers Card -->
    <div class="col-xxl-4 col-md-4">

      <div class="card info-card customers-card">

        <div class="card-body">
          <h5 class="card-title">Buku yang di pinjam </h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-journal-arrow-down"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $buku_dipinjam->count() }}</h6>

            </div>
          </div>

        </div>
      </div>

    </div><!-- End Customers Card -->
    <!-- Customers Card -->
    
    <!-- Customers Card -->
    <div class="col-xxl-12 col-md-4">

      <div class="card info-card info-card">

        <div class="card-body">
          <h5 class="card-title">Buku yang tersedia </h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-journal-check"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $buku_tersedia }}</h6>

            </div>
          </div>

        </div>
      </div>

    </div><!-- End Customers Card -->
@endcan
          
        </div>
      </div><!-- End Left side columns -->
@can('admin-petugas')
     <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total peminjam  <span>/ Minggu</span></h5>

                <!-- Line Chart -->
                <div id="barangChart"></div>
            </div>

        </div>
    </div>  
@endcan
        

    </div>
  </section>
  <script>
     $(document).ready(function() {
        fetch("{{ route('dashboard.graph') }}")
            .then(response => response.json())
            .then(data => {
                drawChart(data);
                console.log(data);
            })
            .catch(error => console.error(error));

        function drawChart(data) {
            let options = {
                chart: {
                  height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false,
                    },
                },
                series: [{
                    name: 'Total ',
                    data: data.map(item => item.total_peminjam)
                }],
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: data.map(item => item.date),
                },
            };

            let chart = new ApexCharts(document.querySelector('#barangChart'), options)
            chart.render();
        }
    });
  </script>
@endsection