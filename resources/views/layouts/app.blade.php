<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ url('/css/bootstrap4-toggle.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ url('/css/adminlte.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/css/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ url('/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ url('/css/bootstrap-datetimepicker.min.css') }}">

    {{-- datatablesを有効にするにはこの位置でないとjqueryを呼んでくれない --}}
    <script src="{{ url('js/jquery.min.js') }}"></script>

    @stack('third_party_stylesheets')
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="{{ url('/uikit/uikit.min.css') }}" />

    {{-- my css --}}
    <link rel="stylesheet" href="{{ url('/css/my_css.css') }}" />

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ url('/images/woggle.png') }}" class="user-image img-circle elevation-2"
                            alt="User Image">
                        @auth
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{ url('/images/woggle.png') }}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                @auth
                                    {{ Auth::user()->name }}
                                    {{-- <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small> --}}
                                @endauth
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            @auth


                                {{-- <a href="#" class="btn btn-default btn-flat">Profile</a> --}}
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    サインアウト
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endauth
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                Copyright &copy; <a href="{{ config('app.url') }}">{{ config('app.name') }}</a> ボーイスカウト東京連盟 AIS委員会 / ICT小委員会
            </div>
        </footer>
    </div>

    {{-- <script src="{{ url('/js/jquery.min.js') }}"></script> --}}

    <script src="{{ url('/js/popper.min.js') }}"></script>

    <script src="{{ url('/js/bootstrap.min.js') }}"></script>

    <script src="{{ url('/js/bs-custom-file-input.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ url('/js/adminlte.min.js') }}"></script>

    <script src="{{ url('/js/moment.min.js') }}"></script>

    <script src="{{ url('/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ url('/js/bootstrap4-toggle.min.js') }}"></script>

    <script src="{{ url('/js/select2.min.js') }}"></script>

    <script src="{{ url('/js/bootstrapSwitch.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    </script>

    @stack('third_party_scripts')

    <!-- UIkit JS -->
    <script src="{{ url('/uikit/uikit.min.js') }}"></script>
    <script src="{{ url('/uikit/uikit-icons.min.js') }}"></script>

    @stack('page_scripts')
</body>

</html>
