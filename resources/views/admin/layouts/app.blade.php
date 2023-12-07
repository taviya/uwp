<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin | @yield('title', 'Panel')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @stack('style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.layouts.header')

        @include('admin.layouts.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('admin.layouts.footer')
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('form-validator/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-notify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function message(msg, type = 'success') {
            $.notify({
                message: msg
            },{
                type: type,
                z_index: 9999,
            });
        }
    </script>
    @if (Session::has('success'))
        <script>
            message("{{ session('success') }}");
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            message("{{ session('error') }}", 'danger');
        </script>
    @endif
    @stack('scripts')
    @stack('custon-scripts')
    <!-- <script src="{{ asset('dist/js/demo.js') }}"></script> -->
</body>

</html>