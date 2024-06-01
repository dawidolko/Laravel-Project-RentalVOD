@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - film: ' . $movie->title])

<head>
    <link rel="stylesheet" href="{{ asset('css/styleLoan.css') }}">
</head>

<body>
    @include('layouts.navbar')

    <div class="container mt-5 marginbig">
        <div class="card">
            <div class="card-body">
                <h1>{{ $movie->title }}</h1>
                <div class="video-container">
                    @if ($movie->video_path)
                    <iframe src="https://www.youtube.com/embed/{{ $movie->video_path }}?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                    <p>Film niedostępne.</p>
                    @endif
                </div>
                <h2>Opis:</h2>
                <p>{{ $movie->description }}</p>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
