<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand red-after" href="{{ route('home') }}">
            <b>RentalVOD</b>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link red-after" href="{{ url('/') }}">Strona główna</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link red-after" href="#" id="rentalDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Wypożycz <i class="bi bi-chevron-down"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="rentalDropdown">
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'rate_desc']) }}">Najwyżej oceniane</a></li>
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'rate_asc']) }}">Najniżej oceniane</a></li>
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'duration_desc']) }}">Najdłuższe</a></li>
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'duration_asc']) }}">Najkrótsze</a></li>
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'release2']) }}">Najnowsze</a></li>
                        <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['sort_by' => 'release1']) }}">Najstarsze</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link red-after" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategorie <i class="bi bi-chevron-down"></i></a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item red-after" href="{{ route('movies.index', ['category' => $category->id]) }}">{{ $category->species }}</a></li>
                        @endforeach
                    </ul>
                </li>                              
                <li class="nav-item">
                    <a class="nav-link red-after" href="{{ route('regulamin') }}">Regulamin</a>
                </li>
                <li class="nav-item">
                    <div class="input-group">
                        <form action="{{ route('movies.search') }}" method="GET" class="d-flex">
                            <input type="text" class="form-control" placeholder="Search..." name="query" id="searchInput" style="display: none;">
                            <button class="btn btn-outline-primary" type="button" id="searchToggle">
                                <i class="bi bi-search"></i>
                            </button>
                            <button class="btn btn-outline-primary d-none" type="submit" id="searchSubmit">
                                Szukaj
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @can('is-admin')
                <li class="nav-item" style="background: rgba(0, 0, 0, 0.5); border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                    <a class="nav-link red-after" href="{{ route('admin.orders') }}">Wypożyczenia</a>
                </li>
                <li class="nav-item" style="background: rgba(0, 0, 0, 0.5);">
                    <a class="nav-link red-after" href="{{ route('admin.users') }}">Edycja użytkowników</a>
                </li>
                <li class="nav-item" style="background: rgba(0, 0, 0, 0.5); margin-right: 10px; border-top-right-radius: 5px;border-bottom-right-radius: 5px;">
                    <a class="nav-link red-after" href="{{ route('admin.movies') }}">Edycja filmów</a>
                </li>
                @endcan
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: rgba(139, 0, 0, 0.5); margin-right: 10px; border-radius: 5px;">Punkty: {{ Auth::user()->loyaltyPoints->points ?? 0 }}</a>
                    </li>
                @endif    
                <li class="nav-item">
                    <button class="nav-link" id="theme-toggle">
                        <i class="bi bi-moon-stars" id="theme-icon"></i>
                    </button>
                </li>        
            </ul>
            <div class="dropdown" id="navbar-user">
                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ url(Auth::user() ? Auth::user()->avatar : 'storage/img/user.png') }}" class="rounded-circle" height="30" alt="Portrait of a User" loading="lazy"/>
                    @if (Auth::check())
                        <span class="ms-2" style="color: inherit; text-decoration: none;">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                    @if (Auth::check())
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}">Mój profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('cart.show') }}">Koszyk</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings') }}">Ustawienia</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Wyloguj się</a></li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Zaloguj się</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @include('layouts.success-toast')
</nav>
