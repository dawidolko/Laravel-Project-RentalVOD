<div id="unique-categories">
    <div class="unique-wrapper noselect">
        <hr>
        <div class="unique-h2c">
            <h2 class="unique-title">KATEGORIE</h2>
        </div>
        <hr>
        <div class="unique-slider-container" style="padding:10px; overflow-x: hidden;">
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