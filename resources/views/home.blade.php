@include('layouts.html')
  
  @include('layouts.slider')
  @include('layouts.head', ['pageTitle' => 'RentalVOD - strona główna'])
  <head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
    <style>
      .top-movies-slider {
          position: relative;
          width: 100%;
          height: 50vh;
          overflow: hidden;
      }
      
      .top-movies-slide {
          position: absolute;
          width: 100%;
          height: 100%;
          background-size: cover;
          background-position: center;
          display: none;
          justify-content: center;
          align-items: center;
          color: white;
          text-align: center;
      }
      
      .top-movies-slide.active {
          display: flex;
      }
      
      .top-movies-content {
          background: rgba(248, 248, 248, 0.55);
          padding: 20px;
          border-radius: 10px;
      }
      .top-movies-controls {
      position: absolute;
      width: 100%;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      justify-content: space-between;
    }

    .top-movies-controls button {
      background: rgba(0, 0, 0, 0.7);
      color: white;
      border: none;
      padding: 20px;
      cursor: pointer;
      font-size: 20px;
    }
      </style>
  </head>
  <body>
    @include('layouts.navbar')

    <div id="carouselExampleInterval" class="carousel slide p-1" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
          <img src="https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/F6CDB6C0EB2D77EB19BCADA31F85066E001A1F61FA68F4AC3356A73FE076477F/scale?width=1440&aspectRatio=1.78&format=jpeg" class="d-block w-100 rounded" alt="sliderLegends">
          <div class="title-overlay" style="background-image: url('https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/DDFF0FDF457E092EE53149CE7DB5BD14CB97E27B92D2D087E7C687B4E3073DE2/scale?width=1440&aspectRatio=1.78');"></div>
        </div>
        <div class="carousel-item" data-bs-interval="10000">
          <img src="https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/2A509165105A09F9F533E2008B143BCF38D6A5859D0EBB40CCA388772005CD94/scale?width=1440&aspectRatio=1.78&format=jpeg" class="d-block w-100 rounded" alt="sliderBurrow">
          <div class="title-overlay" style="background-image: url('https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/DD8BBA864E290FBC03A244A488FFC8DC8365FBF2F95A122B1D57BF3772D717FD/scale?width=1440&aspectRatio=1.78');"></div>
        </div>
        <div class="carousel-item" data-bs-interval="10000">
          <img src="https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/09DAD6A5DAECB6BA9E329FFA896B18978FE4AD5540C070D7973EE53357DD4D24/scale?width=1440&aspectRatio=1.78&format=jpeg" class="d-block w-100 rounded" alt="sliderAnimaion">
          <div class="title-overlay" style="background-image: url('https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/A31BE6502DC7A3A01DAF58DF7E91AB6FF598A078C8FA88A1DB2D7B7E25439464/scale?width=1440&aspectRatio=1.78');"></div>
        </div>
        <div class="carousel-item" data-bs-interval="10000">
          <img src="https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/223DAE104BE1175F374C4AACAC0EB5B8B0DB9C49839AA2E10085533DDFE07A8E/scale?width=1440&aspectRatio=1.78&format=jpeg" class="d-block w-100 rounded" alt="sliderTheSimpsons">
          <div class="title-overlay" style="background-image: url('https://prod-ripcut-delivery.disney-plus.net/v1/variant/disney/47A6FB38D95B3A5EF5583C9EED0B698ED2992CBA4AC7222DD3269DC92DFA03A6/scale?width=1440&aspectRatio=1.78');"></div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>


    <div id="unique-categories">
      <div class="unique-wrapper noselect">
        <hr>
          <div class="unique-h2c">
              <h2 class="unique-title">Kategorie</h2>
          </div>
          <hr>
          <div class="unique-slider-container">
              @foreach ($categories as $category)
                  <a href="{{ route('movies.index', ['category' => $category->id]) }}" class="unique-frame">
                      <img src="{{ asset('storage/img/categories/' . $category->species . '.webp') }}" alt="{{ $category->species }}">
                      <span class="unique-overlay">{{ $category->species }}</span>
                  </a>
              @endforeach
          </div>
          <button class="unique-scroll-left">&lt;</button>
          <button class="unique-scroll-right">&gt;</button>
      </div>
  </div>  

      <div id="imageOverlay" class="image-overlay" style="display: none;">
        <span class="close-btn">&times;</span>
        <img class="overlay-image" src="" alt="Powiększone zdjęcie">
    </div>

    <div class="top-movies-slider" id="topMoviesSlider">
      <div class="unique-h2c">
        <hr>
    </div>
        @foreach ($topMovies as $index => $movie)
        <div class="top-movies-slide @if($index === 0) active @endif" style="background-image: url('{{ asset('storage/' . $movie->img_path) }}')">
            <div class="top-movies-content">
                <h2 style="color: rgb(82, 82, 82); background: rgba(185, 185, 185, 0.793);">{{ $movie->title }}</h2>
                <p style="color: rgb(78, 78, 78); background: rgba(216, 216, 216, 0.793);" >#{{ $index + 1 }} Miejsce</p>
                <p style="color: rgb(94, 94, 94); background: rgba(230, 230, 230, 0.793);">Dostępność: {{ $movie->available }}</p>
                <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="btn btn-block custom-btn" style="width: 200px;">Przejdź do filmu</a>
            </div>
        </div>
        @endforeach
        <div class="top-movies-controls">
            <button id="prevSlide">&lt;</button>
            <button id="nextSlide">&gt;</button>
        </div>
    </div>
    <hr>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.top-movies-slide');
            let currentSlide = 0;
    
            function showSlide(index) {
                slides[currentSlide].classList.remove('active');
                currentSlide = (index + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            }
    
            document.getElementById('prevSlide').addEventListener('click', function() {
                showSlide(currentSlide - 1);
            });
    
            document.getElementById('nextSlide').addEventListener('click', function() {
                showSlide(currentSlide + 1);
            });
        });
    </script>
    
      <div class="new-conti category-section container2 mt-8">
        <div class="product-main">
          <h2 class="title">Wypożycz już dziś</h2>
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
                    <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img hover" style="border-bottom: 1px solid var(--cultured);"/>
                    <img src="{{ asset('storage/' . $movie->img_path) }}" alt="{{ $movie->category->species }}" class="product-img default" style="border-bottom: 1px solid var(--cultured);"/>
        
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
                        @elseif(empty($movie->old_price))
                            <h5 class="card-title"><del>{{ $promoPrice }} zł</del> {{ $movie->price_day }} zł</h5>
                        @else
                            <h5 class="card-title">{{ $movie->price_day }} zł</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="w-100 h-100 btn btn-block custom-btn"><b>Przejdź do filmu</b></a>
                    </div>
                </div>
            </div>
        @endforeach        
            @endif
          </div>
          <hr>
          </div>
        </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script defer src="{{ asset('js/magnification.js') }}"></script>
  </body>
</html>
