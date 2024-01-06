@if (session('success'))
    <script>
        // Mengambil pesan dari flash session
        const message = session('success');

        // Menampilkan SweetAlert
        Swal.fire({
            title: 'Berhasil!',
            text: message,
            icon: 'success'
        })
    </script>
@endif