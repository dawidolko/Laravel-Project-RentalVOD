@include('layouts.html')
  
  @include('layouts.head', ['pageTitle' => 'RentalVOD - filmy'])
  <head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
  </head>
  <body>
    @include('layouts.navbar', ['categories' => $categories])


    <div class="container text-white w-50" style="margin-top:80px;">
        <form action="{{ route('movies.index') }}" method="GET" class="row">
            <div class="form-group col-md-6">
                <label for="species">Gatunek</label>
                <select name="species" id="species" class="form-control">
                    <option value="">Wszystkie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->species }}" {{ request('species') == $category->species ? 'selected' : '' }}>
                            {{ $category->species }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="sort_by">Sortuj według</label>
                <select name="sort_by" id="sort_by" class="form-control">
                    <option value="">Brak sortowania</option>
                    <option {{ request('sort_by') == 'release1' ? 'selected' : '' }} value="release1">Od najstarszego</option>
                    <option {{ request('sort_by') == 'release2' ? 'selected' : '' }} value="release2">Od najmłodszego</option>
                    <option {{ request('sort_by') == 'rate1' ? 'selected' : '' }} value="rate1">Ocena rosnąco</option>
                    <option {{ request('sort_by') == 'rate2' ? 'selected' : '' }} value="rate2">Ocena malejąco</option>
                    <option {{ request('sort_by') == 'length1' ? 'selected' : '' }} value="length1">Długość filmu malejąca</option>
                    <option {{ request('sort_by') == 'length2' ? 'selected' : '' }} value="length2">Długość filmu rosnąca</option>
                </select>
            </div>
            <div class="form-group col-12 text-center">
                <button type="submit" class="btn custom-btn m-2">Filtruj</button>
            </div>
        </form>
    </div>
    
    <div id="imageOverlay" class="image-overlay" style="display: none;">
        <span class="close-btn">&times;</span>
        <img class="overlay-image" src="" alt="Powiększone zdjęcie">
    </div>    

    <div class="container new-conti category-section container mt-5">
            <div class="product-main">
            <h2 class="title">Wszystkie filmy</h2>

            <div class="product-grid">
                @foreach ($movies as $movie)
                    <div class="showcase">
                        <div class="showcase-banner">
                            <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img hover" />
                            <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img default" />
                        
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
                            <div class="card-body">
                            <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="w-100 h-100 btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($movies->isEmpty())
                    <p>Brak filmów.</p>
                @endif

            </div>
        </div>
      </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script defer src="{{ asset('js/magnification.js') }}"></script>
</body>
</html>
