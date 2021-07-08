<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script id="MathJax-script" async src="{{ asset('js/mathjax/tex-chtml-full.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Learn Graph') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item{{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{ Request::is('graphs/12') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/graphs/12') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Introductiv') }}<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{ Request::is('/graphs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("graphs.index") }}"  aria-haspopup="true" aria-expanded="false">{{ __('Grafuri') }}</a>
                    </li>
                    @guest
                        <li class="nav-item{{ Request::is('/graphs/play') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('graphs.play') }}">{{ __('Playground') }}<span class="sr-only">(current)</span></a>
                        </li>
                    @endguest
                    @auth
                    <li class="nav-item dropdown {{ Request::is('graphs/*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="{{ route('graphs.index') }}" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Administration') }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown03">
                            <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                            <a class="dropdown-item" href="{{ route('graphs.index') }}">{{ __('Graphs') }}</a>
                            <a class="dropdown-item" href="{{ route('graphs.draw') }}">{{ __('Draw graph') }}</a>
                            <a class="dropdown-item" href="{{ route('graphs.create') }}">{{ __('Add graph') }}</a>

                        </div>
                    </li>
                    @endauth
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
{{--                <form class="form-inline my-2 my-md-0">--}}
{{--                    <input class="form-control" type="text" placeholder="Search">--}}
{{--                </form>--}}
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @isset($graph22)
        @include('graphs.input-form')
    @endisset
</body>
</html>
