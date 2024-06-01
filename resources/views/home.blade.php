@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - strona główna'])

<head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}" />
</head>

<body>
    @include('layouts.navbar')

    @include('layouts.slider')

    @include('layouts.categories')

    @include('layouts.top10')

    <div id="imageOverlay" class="image-overlay" style="display: none;">
        <span class="close-btn">&times;</span>
        <img class="overlay-image" src="" alt="Powiększone zdjęcie">
    </div>

    <div class="new-conti category-section">
        <div class="product-main">
            <h2 class="title">WYPOŻYCZ JUŻ DZIŚ</h2>
            <hr>
            <div class="product-grid">
                @if ($movies->isEmpty())
                <div class="alert alert-danger" role="alert">
                    BRAK FILMÓW
                </div>
                @else
                @foreach ($movies as $movie)
                <div class="showcase">
                    <div class="showcase-banner">
                        <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img hover" style="border-bottom: 1px solid var(--cultured);" />
                        <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img default" style="border-bottom: 1px solid var(--cultured);" />

                        <div class="showcase-actions">
                            <button class="btn-action magnification">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="btn-action bag-add">
                                <a href="{{ route('movies.show', ['id' => $movie->id]) }}">
                                    <ion-icon name="bag-add-outline"></ion-icon>
                                </a>
                            </button>
                        </div>
                    </div>

                    <div class="showcase-content">
                        <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="showcase-category card-title text-danger2">{{ $movie->category->species }}</a>
                        <a href="{{ route('movies.show', ['id' => $movie->id]) }}">
                            <h3 class="showcase-title">{{ $movie->title }}</h3>
                        </a>
                        <ul class="list-group list-group-flush bg-secondary" style="text-align: center;">
                            <li class="list-group-item bg-dark2">Reżyser: <b>{{ $movie->director }}</b></li>
                            <li class="list-group-item bg-dark3">Rok premiery: <b>{{ $movie->release_year }}</b></li>
                            <li class="list-group-item bg-dark3">Ocena: <b>{{ $movie->rate }}</b></li>
                        </ul>
                        <div class="card-footer text-center" style="background-color: rgba(139, 0, 0, 0.8); padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                            @if(!empty($movie->super_promo_price))
                            <h5 class="card-title">{{ $movie->price_day }} zł <del>{{ $movie->old_price }} zł</del></h5>
                            @elseif($promotionsEnabled && empty($movie->old_price))
                            <h5 class="card-title"><del>{{ $movie->promo_price }} zł</del> {{ $movie->price_day }} zł</h5>
                            @else
                            <h5 class="card-title">{{ $movie->price_day }} zł</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <a href="{{ route('movies.show', ['id' => $movie->id]) }}" style="min-width: 150px; max-height: 50px;" class="w-100 h-100 btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @if (!empty($topRecommendedMovies))
            <hr>
            <div class="unique-h2c">
                <h2 class="unique-title">REKOMENDOWANE DLA CIEBIE</h2>
            </div>
            <hr>
            <div class="container mt-5">
                <div class="row" style="display: flex; justify-content: center;">
                    @foreach ($topRecommendedMovies as $movie)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100" style="border: 1px solid var(--cultured);">
                            <img style="border-bottom: 1px solid white;" src="{{ asset('storage/' . $movie->img_path) }}" class="card-img-top" alt="{{ $movie->title }}">
                            <div class="card-body">
                                <h5 class="card-title" style="text-decoration: underline;color: var(--sonic-silver);">{{ $movie->title }}</h5>
                                <p class="card-text" style="border-radius: 5px; background: #185900; padding: 5px;">Ocena: {{ $movie->rate }}</p>
                                <p class="card-text" style="border-radius: 5px; background: rgba(0,0,0,0.3); font-size:0.7rem; padding: 5px;">Liczba rekomendacji: {{ $movie->recommendations_count }}</p>
                                <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="w-100 h-100 btn btn-block custom-btn" style="max-height:40px; min-width: 150px;">Przejdź do filmu</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <hr>
        </div>
    </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script defer src="{{ asset('js/magnification.js') }}"></script>
    <script defer src="{{ asset('js/topten.js') }}"></script>
</body>

</html>
