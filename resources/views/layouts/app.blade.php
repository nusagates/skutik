<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config("app.name"))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/fontawesome/css/all.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/ckeditor/plugins/prism/lib/prism/prism_patched.min.css')}}"/>
    <link href="{{url('vendor/ckeditor/plugins/chart/chart.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{url('images/icon.png')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-73062055-14"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-73062055-14');
    </script>

    @yield('meta')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img width="30" src="{{url('images/icon2.png')}}"/> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

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
                                {{ Auth::user()->name }}
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
        @yield('content')
    </main>
    <div class="container">
        <!-- Footer -->
        <footer class="page-footer bg-white font-small stylish-color-dark pt-4">

            <!-- Footer Links -->
            <div class="container text-center text-md-left">

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

                        <ul class="list-unstyled">
                            <li><a href="{{route('root')}}">@lang('general.label_home')</a></li>
                            <li><a href="{{url('post/about')}}">@lang('general.label_profile')</a></li>
                            <li><a href="{{url('post/privacy')}}">@lang('general.label_privacy')</a></li>
                            <li><a href="{{url('post/contact')}}">@lang('general.label_contact')</a></li>
                        </ul>

                    </div>
                    <!-- Grid column -->
                    @if(@isset($latest))
                        <hr class="clearfix w-100 d-md-none">
                        <!-- Grid column -->
                        <div class="col-md-2 mx-auto">
                            <!-- Links -->
                            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">@lang('post.label_newest')</h5>
                            <ul class="list-unstyled">
                                @foreach($latest as $item)
                                    <li><a href="{{$item->slug}}">{{$item->post_title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                @endif
                <!-- Grid column -->


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
<script src="{{url('vendor/ckeditor/plugins/prism/lib/prism/prism_patched.min.js')}}"></script>
<script src="{{url('vendor/ckeditor/plugins/chart/lib/chart.min.js')}}"></script>
<script src="{{url('vendor/ckeditor/plugins/chart/widget2chart.js')}}"></script>
@yield('script')
</body>
</html>
