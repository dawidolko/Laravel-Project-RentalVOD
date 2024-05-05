@include('layouts.html')
  
  @include('layouts.slider')
  @include('layouts.head', ['pageTitle' => 'RentalVOD - strona główna'])
  <head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
<style>
    .list-group-item {
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .list-group-item .text-white {
            margin-bottom: 1rem;
        }

        .list-group-item .wrap {
            margin-top: 1rem;
        }
    }
</style>
</head>
<body>
  @include('layouts.navbar')

{{-- 
<div class="container w-100">
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        @foreach ($errors->all() as $error)
            <strong>{{ $error }}</strong>
        @endforeach
    </div>
    @elseif (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'movie')">Dodaj film</a>
        <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'category')">Dodaj kategorię</a>
    </div>
    <li id="add-panel-movie" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" class="form-control" id="title" name="title" required value="">
            </div>
            <div class="form-group">
                <label for="genre">Gatunek</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Wybierz</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->genre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <input type="text" class="form-control" id="description" name="description" required value="">
            </div>
            <div class="form-group">
                <label for="director">Reżyser</label>
                <input type="text" class="form-control" id="director" name="director" required value="">
            </div>
            <div class="form-group">
                <label for="release">Rok premiery</label>
                <input type="number" class="form-control" id="release" min="1900" max="2100" name="release" required value="">
            </div>
            <div class="form-group">
                <label for="longTime">Czas trwania w minutach</label>
                <input type="number" class="form-control" id="longTime" min="0" name="longTime" required value="">
            </div>
            <div class="form-group">
                <label for="rate">Ocena</label>
                <input type="number" step="any" class="form-control" id="rate" min="0" max="10" name="rate" required value="">
            </div>
            <div class="form-group">
                <label for="pricePerDay">Cena za dzień</label>
                <input type="number" class="form-control" step="any" id="pricePerDay" min="0" max="100" name="pricePerDay" required value="">
            </div>
            <div class="form-group">
                <label for="image">Dodaj zdjęcie</label>
                <input type="file" class="form-control" id="img_path" name="img_path">
            </div>
            <div class="form-group">
                <label for="available">Dostępność</label>
                <select id="available" name="available" class="form-control">
                    <option value="dostępny">dostępny</option>
                    <option value="niedostępny">niedostępny</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Dodaj</button>
        </form>
        <li id="add-panel-category" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
            <form action="{{route('category.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="genre">Nazwa nowego gatunku</label>
                    <input type="text" class="form-control" id="genre" required name="genre" value="">
                </div>
                <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Dodaj</button>
            </form>
        </li>
    </li>
    <ul class="list-group">
        @foreach($movies as $movie)
            <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
                <div class="text-white">
                    <span class="fw-bold">{{ $movie->id }}</span>
                    <span class="fw-bold">{{ $movie->title }}</span>
                    <span class="">Premiera: {{ $movie->release }}</span>
                    <span class="">Dostępność: {{ $movie->available }}</span>
                </div>
                <div>
                    <a href="#" style="" class="btn btn-secondary custom-btn" onclick="toggleEditPanel(event, {{ $movie->id }})">Edytuj</a>

                    <a href="{{ route('movies.delete', ['id' => $movie->id]) }}" class="btn btn-danger @if ($movie->available == 'niedostępny') disabled @endif">Usuń</a>
                </div>
            </li>
            <li id="edit-panel-{{ $movie->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">

                <form action="{{ route('movies.update', ['id' => $movie->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tytuł</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $movie->title }}">
                    </div>
                    <div class="form-group">
                        <label for="genre">Gatunek</label>
                        <select id="category_id" name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $movie->category_id) selected @endif>{{ $category->genre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Opis</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $movie->description }}">
                    </div>
                    <div class="form-group">
                        <label for="director">Reżyser</label>
                        <input type="text" class="form-control" id="director" name="director" value="{{ $movie->director }}">
                    </div>
                    <div class="form-group">
                        <label for="release">Rok premiery</label>
                        <input type="number" class="form-control" id="release" name="release" min="1900" max="2100" value="{{ $movie->release }}">
                    </div>
                    <div class="form-group">
                        <label for="longTime">Czas trwania w minutach</label>
                        <input type="number" class="form-control" id="longTime" name="longTime" max="1000" min="0" value="{{ $movie->longTime }}">
                    </div>
                    <div class="form-group">
                        <label for="rate">Ocena</label>
                        <input type="number" step="any" class="form-control" id="rate" name="rate" min="0" max="10" value="{{ $movie->rate }}">
                    </div>
                    <div class="form-group">
                        <label for="pricePerDay">Cena za dzień</label>
                        <input type="number" step="any" class="form-control" id="pricePerDay" name="pricePerDay" max="1000" min="0" value="{{ $movie->pricePerDay }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Zmień zdjęcie</label>
                        <input type="file" class="form-control" id="img_path" name="img_path">
                    </div>
                    <div class="form-group">
                        <label for="available">Dostępność</label>
                        <select id="available" name="available" class="form-control">
                            <option value="{{ $movie->available }}" selected>{{ $movie->available }}</option>
                            @if ($movie->available == "dostępny")
                                <option value="niedostępny">niedostępny</option>
                            @else
                                <option value="dostępny">dostępny</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary custom-btn m-2 w-30">Zapisz</button>
                    <button type="button" class="btn btn-secondary custom-btn m-2 w-30" onclick="cancelEditPanel(event, {{ $movie->id }})">Anuluj</button>
                </form>
            </li>
        @endforeach
    </ul>
</div> --}}
@include('layouts.footer', ['fixedBottom' => false])
<script defer src="{{ asset('js/magnification.js') }}"></script>
</body>
</html>
