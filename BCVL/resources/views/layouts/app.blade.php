<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BCVL') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- UI/Designs --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://kit.fontawesome.com/b87fe33100.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="app">
        @auth
            <nav class="navbar navbar-expand-md navbar-light shadow-sm border-bottom ">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
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
                                @if ($currentUrl === 'home')
                                    <div class="d-flex align-items-center">
                                        <img src="{{ URL::asset('images/dp.png') }}" onclick="console.log('test')"
                                            alt="User Image" width="25" height="25">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" v-pre>
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
                                            </div>
                                        </li>
                                    </div>
                                @endif
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth

        @auth
            <aside class="sidebar shadow">
                <img class="mt-3" src="{{ URL::asset('images/logo.png') }}" alt="Image not loaded" height="50"
                    width="100">
                <a href="/home"
                    class="item text-decoration-none text-dark d-flex justify-content-center align-items-center rounded mb-2 mt-3">

                    <svg xmlns="http://www.w3.org/2000/svg" height="15" width="16.25" viewBox="0 0 576 512">
                        <path fill="#c7c7c7"
                            d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                    </svg>
                    <span class="ms-1 fw-medium">Home</span>
                </a>

                @if (Auth::user()->role == 'Instructor')
                    <button class="create_class rounded fw-medium mb-4 p-2" onclick="showModal()">Create Class</button>
                @endif

                <div class="d-flex align-items-center rounded" style="width: 80%">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25"
                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="#9c9c9c"
                            d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                    </svg>
                    <span class="ms-1 fw-medium">All Classes</span>
                </div>
                <div class="container-fluid overflow-auto d-flex flex-column align-items-center p-0 pb-3"
                    style="max-height: 80vh;">
                    <div class="scrollable-content">
                        @foreach ($classes as $class)
                            <a class="col-md-12 text-decoration-none"
                                href="{{ route('class.show', ['id' => $class->id]) }}">
                                <div class="class_side">
                                    <div class="card-body d-flex align-items-center mb-1">
                                        <span class="d-flex justify-content-between align-items-center" style="width: 100%">
                                            <span class="fw-medium me-1 text-secondary">{{ $class->subject }} </span>
                                            <span class="yearsec fw-medium m-none text-dark">
                                                <small>{{ $class->yearsec }}</small>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        @endauth

        <dialog id="my-modal" class="popup p-5 rounded border border-0">
            <form action="{{ route('class.store') }}" method="post">
                @csrf
                @if (auth()->check())
                    <input type="hidden" name="instructor_id" value="{{ auth()->user()->id }}">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="subject" placeholder="Subject Name"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="yearsec" placeholder="Year and Section"
                            required>
                    </div>
                    <div class="options">
                        <button class="btn btn-outline-secondary rounded" id="close-button"
                            onclick="closeModal()">Cancel</button>
                        <input type="submit" class="btn btn-primary rounded" value="Create" />
                    </div>
                @else
                    <p>Your session has expired due to inactivity. Please log in again to continue.</p>
                @endif
            </form>
        </dialog>

        <main style="{{ auth()->check() ? 'margin-left: 17vw;' : '' }}">
            @auth
                @if ($currentUrl === 'home')
                    @yield('content')
                @else
                    @yield('class')
                @endif
            @else
                @yield('content')
            @endauth
        </main>

    </div>

    <script>
        function showModal() {
            document.getElementById('my-modal').showModal();
        }

        function closeModal() {
            document.getElementById('my-modal').close();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

</body>

</html>
