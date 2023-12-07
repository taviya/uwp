<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Question & Ans</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Question & Ans">
    <meta name="author" content="SW-THEMES">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="assets/images/icons/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <style>
        .dropdown-toggle:hover + .dropdown-menu{
            display: block;
        }

        .dropdown-menu:hover {
            display: block;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        @include('user.layouts.header')
        @yield('content')
    </div>
    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('form-validator/jquery.form-validator.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-notify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
    @stack('scripts')
    @stack('custon-scripts')
</body>

</html>