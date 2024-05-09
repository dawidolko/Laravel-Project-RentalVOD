@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - Admin Movies'])
<head>
    <style>
        html, body {
            height: 100%; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; 
        }

        .container {
            flex: 1; 
            display: flex;
            flex-direction: column; 
        }

        .footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <div class="container mt-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h1>Wszystkie filmy</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'movie')">Dodaj film</a>
            <a href="#" class="btn btn-secondary custom-btn" onclick="toggleAddPanel(event, 'category')">Dodaj kategorię</a>
        </div>

        <li id="add-panel-movie" class="list-group-item edit-panel" style="display: none;">
            <form action="{{ route('admin.addMovie') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tytuł</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Opis</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="category_id">Nazwa Kategorii</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->species }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="director">Reżyser</label>
                    <input type="text" class="form-control" id="director" name="director" required>
                </div>
                <div class="form-group">
                    <label for="release_year">Rok Produkcji</label>
                    <input type="number" class="form-control" id="release_year" name="release_year" required>
                </div>
                <div class="form-group">
                    <label for="duration">Czas Filmu</label>
                    <input type="text" class="form-control" id="duration" name="duration" pattern="[0-9]*" title="Czas filmu musi być liczbą" required>
                    @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="rate">Ocena</label>
                    <input type="number" step="0.01" class="form-control" id="rate" name="rate" required>
                </div>
                <div class="form-group">
                    <label for="img_path">Zdjęcie</label>
                    <input type="file" class="form-control" id="img_path" name="img_path" required>
                </div>
                <div class="form-group">
                    <label for="video_path">Ścieżka do Filmu</label>
                    <input type="text" class="form-control" id="video_path" name="video_path" required>
                </div>
                <div class="form-group">
                    <label for="price_day">Cena za Dzień</label>
                    <input type="number" step="0.01" class="form-control" id="price_day" name="price_day" required>
                </div>
                <div class="form-group">
                    <label for="available">Dostępność</label>
                    <select class="form-control" id="available" name="available" required>
                        <option value="dostępny">Dostępny</option>
                        <option value="niedostępny">Niedostępny</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary custom-btn m-2">Dodaj</button>
            </form>
        </li>

        <li id="add-panel-category" class="list-group-item edit-panel" style="display: none;">
            <form action="{{ route('admin.addCategory') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="genre">Nazwa nowego gatunku</label>
                    <input type="text" class="form-control" id="genre" name="genre" required>
                </div>
                <button type="submit" class="btn btn-secondary custom-btn m-2">Dodaj</button>
            </form>
        </li>

        <div class="table-responsive"> 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Zdjęcie</th>
                    <th style="text-align: center">Tytuł</th>
                    <th style="text-align: center">Opis</th>
                    <th style="text-align: center">ID Kategorii</th>
                    <th style="text-align: center">Reżyser</th>
                    <th style="text-align: center">Rok Produkcji</th>
                    <th style="text-align: center">Czas Filmu</th>
                    <th style="text-align: center">Ocena</th>
                    <th style="text-align: center">Ścieżka do Filmu</th>
                    <th style="text-align: center">Cena za Dzień</th>
                    <th style="text-align: center">Dostępność</th>
                    <th style="text-align: center">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td><img src="{{ asset('storage/'. $movie->img_path) }}" alt="{{ $movie->title }}" width="100"></td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->description }}</td>
                    <td>{{ $movie->category_id }}</td>
                    <td>{{ $movie->director }}</td>
                    <td>{{ $movie->release_year }}</td>
                    <td>{{ $movie->duration }}</td>
                    <td>{{ $movie->rate }}</td>
                    <td>{{ $movie->video_path }}</td>
                    <td>{{ $movie->price_day }}</td>
                    <td>{{ $movie->available }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary" onclick="openEditPanel({{ $movie->id }})" style="margin-bottom: 10px;">Edytuj</button>
                        <form action="{{ route('admin.deleteMovie', ['id' => $movie->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        </form>
                    </td>
                </tr>
                <tr id="edit-panel-{{ $movie->id }}" style="display: none;">
                    <td colspan="13">
                        <form id="edit-form-{{ $movie->id }}" method="POST" action="{{ route('admin.updateMovie', ['id' => $movie->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Tytuł</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $movie->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Opis</label>
                                <textarea class="form-control" id="description" name="description" required>{{ $movie->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="category_name">Nazwa Kategorii</label>
                                <select class="form-control" id="category_name" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $movie->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->species }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                                
                            <div class="form-group">
                                <label for="director">Reżyser</label>
                                <input type="text" class="form-control" id="director" name="director" value="{{ $movie->director }}" required>
                            </div>
                            <div class="form-group">
                                <label for="release_year">Rok Produkcji</label>
                                <input type="number" class="form-control" id="release_year" name="release_year" value="{{ $movie->release_year }}" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Czas Filmu</label>
                                <input type="text" class="form-control" id="duration" name="duration" value="{{ $movie->duration }}" required>
                            </div>
                            <div class="form-group">
                                <label for="rate">Ocena</label>
                                <input type="number" class="form-control" id="rate" name="rate" value="{{ $movie->rate }}" required>
                            </div>
                            <div class="form-group">
                                <label for="video_path">Ścieżka do Filmu</label>
                                <input type="text" class="form-control" id="video_path" name="video_path" value="{{ $movie->video_path }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price_day">Cena za Dzień</label>
                                <input type="number" class="form-control" id="price_day" name="price_day" value="{{ $movie->price_day }}" required>
                            </div>
                            <div class="form-group">
                                <label for="available">Dostępność</label>
                                <select class="form-control" id="available" name="available" required>
                                    <option value="dostępny" {{ $movie->available == 'dostępny' ? 'selected' : '' }}>Dostępny</option>
                                    <option value="niedostępny" {{ $movie->available == 'niedostępny' ? 'selected' : '' }}>Niedostępny</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="img_path">Nowe Zdjęcie</label>
                                <input type="file" class="form-control" id="img_path" name="img_path">
                                @error('img_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-secondary custom-btn m-2">Zapisz</button>
                            <button type="button" class="btn btn-secondary custom-btn m-2" onclick="closeEditPanel({{ $movie->id }})">Anuluj</button>
                        </form>
                    </td>
                </tr>                
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $movies->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script defer src="{{ asset('js/magnification.js') }}"></script>
    <script>
        function openEditPanel(movieId) {
            document.getElementById('edit-panel-' + movieId).style.display = 'table-row';
        }

        function closeEditPanel(movieId) {
            document.getElementById('edit-panel-' + movieId).style.display = 'none';
        }
    </script>
    <script>
        function toggleAddPanel(event, type) {
            event.preventDefault();
            let panel = type === 'movie' ? 'add-panel-movie' : 'add-panel-category';
            let display = document.getElementById(panel).style.display;
            document.getElementById(panel).style.display = display === 'none' ? 'block' : 'none';
        }
    
        function openEditPanel(movieId) {
            document.getElementById('edit-panel-' + movieId).style.display = 'table-row';
        }
    
        function closeEditPanel(movieId) {
            document.getElementById('edit-panel-' + movieId).style.display = 'none';
        }
    </script>
    
</body>
</html>
