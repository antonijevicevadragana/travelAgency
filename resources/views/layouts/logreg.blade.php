<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ URL::asset('style2.css') }} ">
    <link rel="icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> --}}
        <nav class="navbar navbar-expand-lg nav">
            <div class="container-fluid">

                <a class="navbar-brand navigacija" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img src="{{ asset('img/laste.png') }}" alt="" class="logo">

                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ">

                        <li class="nav-item">
                            @if ($currentLocale == 'en')
                                <span class="nav-link text-light">EN</span>
                            @else
                                <a class="nav-link text-primary" href="{{ route('lang', ['locale' => 'en']) }}">EN</a>
                            @endif

                        </li>
                        <li class="nav-item">
                            @if ($currentLocale == 'sr')
                                <span class="nav-link text-light">SR</span>
                            @else
                                <a class="nav-link text-primary" href="{{ route('lang', ['locale' => 'sr']) }}">SR</a>
                            @endif
                        </li>

                        {{-- administracija mogu da vide samo admini - rola 1 --}}
                        {{-- prvo se vrsi provera da li korisnik prijavljen i ako je i rola je 1 onda je administracija vidljiva--}}
                        @if (auth()->check() && auth()->user()->roles->first()->type == 1)
                            <li class="nav-item dropdown text-light">
                                <a id="navbarAdministacija" class="nav-link dropdown-toggle navigacija" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    <i class="fa-solid fa-gear"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAdministacija">
                                    <a class="dropdown-item navigacijadropdown"
                                        href="{{ route('destination.create') }}">
                                        {{ __('Kreiraj destinaciju') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('hotel.create') }}">
                                        {{ __('Kreiraj hotel') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('hotel.index') }}">
                                        {{ __('Spisak hotela') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown"
                                        href="{{ route('reservation.index') }}">
                                        {{ __('Rezervacije') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('all') }}">
                                        {{ __('Sve ponude') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('user.index') }}">
                                        {{ __('Korisnici') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('feedback.index') }}">
                                        {{ __('Recenzije') }}
                                    </a>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('blog.allBlog') }}">
                                        {{ __('Blogovi') }}
                                    </a>
                                </div>

                            </li>
                        @endif

                        {{-- celokupna ponuda --}}

                        <li class="nav-item dropdown text-light">
                            <a id="navbarAdministacija" class="nav-link dropdown-toggle navigacija" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-pre>
                                {{ __('Ponuda') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAdministacija">
                                <a class="dropdown-item navigacijadropdown"
                                    href="{{ route('destination.index') }}">{{ __('Aktuelna ponuda') }}
                                </a>

                                <a class="dropdown-item navigacijadropdown"
                                    href="{{ route('destination.summer') }}">{{ __('Letovanje') }}
                                </a>

                                <a class="dropdown-item navigacijadropdown"
                                    href="{{ route('destination.winter') }}">{{ __('Zimovanje') }}
                                </a>

                                <a class="dropdown-item navigacijadropdown"
                                    href="{{ route('destination.trip') }}">{{ __('Izleti') }}
                                </a>

                                <a class="dropdown-item navigacijadropdown"
                                    href="{{ route('destination.citybreak') }}">{{ __('City Break') }}
                                </a>
                            </div>

                        </li>


                        <li class="nav-item ">
                            <a class="nav-link navigacija"
                                href="{{ route('destination.first') }}">{{ __('Frist Minute') }}</a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link navigacija"
                                href="{{ route('destination.last') }}">{{ __('Last Minute') }}</a>
                        </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto ">
                        <li class="nav-item ">
                            <a class="nav-link navigacija" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link navigacija" href="{{ route('aboutUs') }}">{{ __('O nama') }}</a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link navigacija" href="{{ route('login') }}"><i
                                            class="fa-solid fa-arrow-right-to-bracket"></i> {{ __('Prijava') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link navigacija" href="{{ route('register') }}"><i
                                            class="fa-solid fa-user-plus"></i> {{ __('Registracija') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre >
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item navigacijadropdown" href="{{ route('myProfile') }}">
                                        {{ __('Moj Profil') }}
                                    </a>

                                    <a class="dropdown-item navigacijadropdown" href="{{ route('myBlog') }}">
                                        {{ __('Moji Blogovi') }}
                                    </a>

                                    <a class="dropdown-item navigacijadropdown" href="{{ route('myfeedbacks') }}">
                                        {{ __('Moje Recenzije') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @if (session('alertMsg'))
                            <div class="alert alert-{{ session('alertType') }} alert-dismissible fade show"
                                role="alert">
                                {{ __(session('alertMsg')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="col-md-8">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ __(session('status')) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
                @yield('content')
        </main>

    </div>

    <footer class="fixed-bottom text-center text-white" style="background-color: #0a4275;">
        <div class="container p-4 pb-0">

            <p> Copyright &copy; 2023, All Rights reserved</p>
        </div>
    </footer>

    {{-- <footer class="text-center text-white" style="background-color: #0a4275;">
            <div class="container p-4 pb-0">
                <p>Copyright &copy; 2023, All Rights reserved</p>
            </div>
        </footer>  --}}

</body>

</html>