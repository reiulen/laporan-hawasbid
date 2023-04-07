<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> {{ $title }} | APLIKASI LAPORAN HAWASBID PENGADILAN AGAMA CIREBON</title>
    <link rel="icon" type="image/png" href="" />

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    @stack('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

  </head>
  <body class="sidebar-mini layout-fixed layout-navbar-fixed">

    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="{{ asset('assets/images/logo-user.png') }}" alt="Logo Pengadilan Agama Cirebon"
                height="300"
                style="object-fit: cover" />
        </div>
        <x-navbar></x-navbar>
        <x-sidebar></x-sidebar>
        <div class="content-wrapper">
            {{ $slot }}
        </div>
    </div>

    @stack('modals')

    <footer class="main-footer" style="font-size: 14px;">
        Copyright &copy; Community {{ date('Y') }}
      </footer>
    </div>
    <!-- ./wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.0/axios.min.js"
		integrity="sha512-yt+yearry6Evoodvr9oWzfGBYcXRyXAbJNZRyD7bHUHs39vj82vnRv1zCqzdh+bShT+c9IQ4T+uX3CmLofd4ig=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
      const url = '{{ url('') }}';
    </script>

    @stack('script')

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/global.js') }}"></script>
    @if (session('success'))
        <script>
          Swal.fire(
          'success',
          '{{ session('success') }}',
          'success'
          );
        </script>
    @endif
  </body>
</html>
