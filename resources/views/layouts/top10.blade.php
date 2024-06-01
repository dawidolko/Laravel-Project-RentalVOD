<div class="top-movies-slider" id="topMoviesSlider">
    <hr>
    <div class="unique-h2c">
        <h2 class="unique-title">TOP 10</h2>
    </div>
    <hr>
    <div style="padding:10px;">
        @foreach ($topMovies as $index => $movie)
        <div class="top-movies-slide @if($index === 0) active @endif" style="background-image: url('{{ asset('storage/' . $movie->img_path) }}');">
            <div class="top-movies-content">
                <h2 style="background: rgba(88, 88, 88, 0.7);">{{ $movie->title }}</h2>
                <p style="background: rgba(88, 88, 88, 0.7);">#{{ $index + 1 }} Miejsce</p>
                <p style="background: rgba(88, 88, 88, 0.7);">Dostępność: {{ $movie->available }}</p>
                <a href="{{ route('movies.show', ['id' => $movie->id]) }}" class="btn btn-block custom-btn" style="min-width: 200px;">Przejdź do filmu</a>
            </div>
        </div>
        @endforeach
        <div class="top-movies-controls">
            <button id="prevSlide">&lt;</button>
            <button id="nextSlide">&gt;</button>
        </div>
    </div>
</div>
<hr>