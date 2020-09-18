<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- PWA -->
    <link rel="manifest" href="{{url('manifest.json')}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Weather PWA">
    <link rel="apple-touch-icon" href="images/icon_152.png">
    <meta name="theme-color" content="#08472d"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', set_title())</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <script defer src="{{ mix('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//fonts.googleapis">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{url('vendor/prismjs/prism.css')}}"/>
    <link rel="shortcut icon" href="{{url('images/icon.png')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->

    @yield('meta')
    @if(Request::segment(1)!='todo')
        <script data-ad-client="ca-pub-3544553303695951" async
                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endif
</head>
<body>
<div id="app">
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="Logo Skutik" width="30"
                     src="{{url('images/icon2.png')}}"/> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('root') }}"><i
                                class="fa fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.index') }}"><i
                                class="fa fa-book"></i> Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('challenge.index') }}"><i class="fa fa-gamepad"></i> Challenge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('todo.index') }}"><i class="fa fa-list"></i> Todo</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="mb-5"></div>
        @yield('content')
    </main>
    <div class="container">
        <!-- Footer -->
        <footer class="page-footer bg-white font-small stylish-color-dark pt-4">

            <!-- Footer Links -->
            <div class="container text-md-left">

                <!-- Grid row -->
                <div class="row">

                    <!-- Grid column -->
                    <div class="col-md-4 mx-auto">

                        <!-- Content -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">SKUTIK</h5>
                        <p>Dibuat oleh Blogger Sejoli yang ditujukan untuk berbagi kisah dan ragam tulisan menarik
                            lainnya.</p>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 mx-auto">

                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">@lang('general.label_about')</h5>

                        <ul class="fa-ul">
                            <li class="mb-2"><i class="fa fa-home fa-li"></i> <a class="btn-link"
                                                                                 href="{{route('root')}}">@lang('general.label_home')</a>
                            </li>
                            <li class="mb-2"><i class="fa fa-user fa-li"></i> <a class="btn-link"
                                                                                 href="{{url('post/about')}}">@lang('general.label_profile')</a>
                            </li>
                            <li class="mb-2"><i class="fa  fa-exclamation-circle fa-li"></i> <a class="btn-link"
                                                                                                href="{{url('post/privacy')}}">@lang('general.label_privacy')</a>
                            </li>
                            <li class="mb-2"><i class="fa fa-address-book fa-li"></i> <a class="btn-link"
                                                                                         href="{{url('post/contact')}}">@lang('general.label_contact')</a>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->
                    <hr class="clearfix w-100 d-md-none">


                </div>
                <!-- Grid row -->

            </div>
            <!-- Footer Links -->

            <hr>

            <!-- Call to action -->
            <ul class="list-unstyled list-inline text-center py-2">
                <li class="list-inline-item">
                    <h5 class="mb-1">@lang('general.label_want_to_write')</h5>
                </li>
                <li class="list-inline-item">
                    <a href="{{route('register')}}"
                       class="btn btn-danger btn-rounded">@lang('general.label_register')</a>
                </li>
            </ul>
            <!-- Call to action -->


            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <a href="{{route('root')}}"> Skutik.com</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
    </div>
</div>
@include('ckfinder::setup')
@yield('script')
</body>
</html>
