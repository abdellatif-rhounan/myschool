<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    @vite('resources/css/app.css')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <a href="javascript:;" class="h1">
                    <b>{{ config('app.name') }}</b>
                </a>
            </div>

            <div class="card-body">
                @include('includes.session_msg')

                <p class="login-box-msg">@yield('box_msg')</p>

                <form method="post">
                    @csrf

                    <div class="input-group mb-3">
                        @yield('input1')

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="@yield('input1_icon')"></span>
                            </div>
                        </div>

                        @yield('input1_invalid_feedback')
                    </div>

                    @yield('next_input_group')

                    <div class="row">
                        @yield('form_submit_area')
                    </div>
                </form>

                @yield('links')
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
