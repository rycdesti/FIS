<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Album example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.min.css" defer>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js" defer></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/i18n/defaults-*.min.js" defer></script>

{{--<!-- Semantic UI core CSS -->--}}
{{--<link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">--}}
{{--<script src="{{ asset('js/semantic.min.js') }}"></script>--}}

<!-- Custom styles for this template -->
    <link href="css/album.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">

            <!-- Left Side Of Navbar -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>&nbsp;&nbsp;

            {{--<a href="{{ url('home') }}" class="navbar-brand d-flex align-items-center">--}}
                {{--<strong>Home</strong>--}}
            {{--</a>--}}

            {{--<!-- Right Side Of Navbar -->--}}
            {{--<ul class="navbar-nav ml-auto">--}}
                {{--<!-- Authentication Links -->--}}
                {{--@guest--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item">--}}
                        {{--@if (Route::has('register'))--}}
                            {{--<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--@endif--}}
                    {{--</li>--}}
                {{--@else--}}
                    {{--<a class="navbar-brand d-flex align-items-center" href="{{ route('logout') }}"--}}
                       {{--onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
                        {{--<strong>{{ __('Logout') }}</strong>--}}
                    {{--</a>--}}

                    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
                          {{--style="display: none;">--}}
                        {{--@csrf--}}
                    {{--</form>--}}
                {{--@endguest--}}
            {{--</ul>--}}
        </div>
    </div>

    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 py-4">
                    <ul class="list-unstyled">

                        <li>
                            <a href="#" class="text-white navbar-brand d-flex align-items-center" data-toggle="collapse"
                               data-target="#financialMenu"
                               aria-controls="financialMenu" aria-expanded="false" aria-label="Toggle navigation">
                                Financial Management
                            </a>
                        </li>

                        <div class="collapse bg-dark" id="financialMenu">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-10 offset-md-1 py-1 form-inline" style="color: #fbbd08">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <span>&nbsp;Lookup</span>
                                    </div>
                                    <div class="col-sm-10 offset-md-2 py-1">
                                        <ul class="list-unstyled">
                                            <li><a href="{{ url('/financial/account_category') }}" class="text-muted">Manage
                                                    Account Category</a></li>
                                            <li><a href="{{ url('/financial/chart_account') }}" class="text-muted">Manage
                                                    Chart of Accounts</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <li><a href="#" class="text-white navbar-brand d-flex align-items-center" data-toggle="collapse"
                               data-target="#apMenu"
                               aria-controls="apMenu" aria-expanded="false" aria-label="Toggle navigation">Accounts
                                Payable</a>
                        </li>

                        <div class="collapse bg-dark" id="apMenu">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-10 offset-md-1 py-1 form-inline" style="color: #21ba45">
                                        <i class="fa fa-reply-all" aria-hidden="true"></i>
                                        <span>&nbsp;Transact</span>
                                    </div>
                                    <div class="col-sm-10 offset-md-2 py-1">
                                        <ul class="list-unstyled">
                                            <li><a href="#" class="text-muted">Manage Monthly Payments</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-10 offset-md-1 py-1 form-inline" style="color: #fbbd08">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <span>&nbsp;Lookup</span>
                                    </div>
                                    <div class="col-sm-10 offset-md-2 py-1">
                                        <ul class="list-unstyled">
                                            <li><a href="#" class="text-muted">Manage Recurring Payments</a></li>
                                            <li><a href="#" class="text-muted">Manage Accounts Payable Roles</a></li>
                                            <li><a href="{{ url('/ap/bank') }}" class="text-muted">Manage Banks</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

</body>
<main class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 card card-title p-4">
                @yield('title')
            </div>
            <div class="col-sm-12 p-2">
                @yield('button')
            </div>
            <div class="col-sm-12 p-2">
                @yield('content')
            </div>
        </div>
    </div>
</main>

</body>

@include('layouts.modal')

</html>