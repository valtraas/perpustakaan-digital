<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="{{ request()->routeIs('dashboard.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('dashboard.index') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      @can('admin-petugas')
      <li class="nav-heading">Kelola Buku</li>
      <li class="nav-item">
        <a class="{{ request()->routeIs('daftar-buku.*') ? 'nav-link' : 'nav-link collapsed'  }}" href="{{ route('daftar-buku.index') }}">
          <i class="bx bxs-book"></i>
          <span>Daftar Buku</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="{{ request()->routeIs('kategori-buku.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('kategori-buku.index') }}">
          <i class="bx bxs-category"></i>
          <span>Kategori Buku</span>
        </a>
      </li>
      @endcan
      {{-- @can('petugas')
          
      @endcan --}}
      <li class="nav-heading">Peminjaman</li>

      <li class="nav-item ">
        <a class="{{ request()->routeIs('daftar-peminjam.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('daftar-peminjam.index') }}">
          <i class="ri-contacts-book-2-fill"></i>
          <span>Daftar Pinjaman</span>
        </a>
      </li>
      @can('petugas')
          
      <li class="nav-item ">
        <a class="{{ request()->routeIs('daftar-permohonan.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('daftar-permohonan.index') }}">
          <i class="ri-contacts-book-upload-fill"></i> 

          <span>Daftar Permohonan</span>
        </a>
      </li>
      @endcan
      

      @can('peminjam')
      <li class="nav-heading">Peminjaman</li>
<li class="nav-item">
        <a class="{{ request()->routeIs('peminjam.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('peminjam.daftar') }}">
          <i class="bx bxs-book"></i>
          <span>Daftar Buku</span>
        </a>
      </li>
          <li class="nav-item ">
        <a class="{{ request()->routeIs('daftar-buku-pinjaman.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('daftar-buku-pinjaman.index') }}">
          <i class="ri-book-read-fill"></i>
          <span>Daftar Buku yang dipinjam</span>
        </a>
      </li>
          <li class="nav-item ">
        <a class="{{ request()->routeIs('pesan.buku') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('pesan.buku') }}">
          <i class="bx bxs-alarm"></i> 
          <span>Permohonan peminjaman buku</span>
        </a>
      </li>
      @endcan
      
      @can('admin-petugas')
             <li class="nav-heading">Laporan</li>

      <li class="nav-item ">
        <a class="{{ request()->routeIs('laporan.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('laporan.all') }}">
          <i class="ri-book-read-fill"></i>
          <span>Laporan</span>
        </a>
      </li>
      @endcan
   
      <!-- End Components Nav -->
      <!-- End Dashboard Nav -->

      <li class="nav-heading">Lainnya</li>

      <li class="nav-item">
        <a class="{{ request()->routeIs('profile.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('profile.index',['user'=>auth()->user()->username]) }}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>
      <!-- End Profile Page Nav -->
      @can('admin')
           <li class="nav-item">
        <a class="{{ request()->routeIs('user.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('user.index') }}">
          <i class="bi bi-people-fill"></i>
          <span>Daftar User</span>
        </a>
      </li>
      @endcan
    
@can('peminjam')
       <li class="nav-item">
        <a class="{{ request()->routeIs('koleksi.*') ? 'nav-link' : 'nav-link collapsed'  }} " href="{{ route('koleksi.index') }}">
          <i class="bi bi-journal-bookmark-fill"></i>
          <span>Koleksi pribadi</span>
        </a>
      </li><!-- End Koleksi pribadi Page Nav -->
@endcan
    </ul>

  </aside><!-- End Sidebar-->