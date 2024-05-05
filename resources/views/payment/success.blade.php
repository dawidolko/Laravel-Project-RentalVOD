@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - Koszyk'])
<head>
    <link rel="stylesheet" href="{{ asset('css/movieStyle.css') }}" />
    <style>
        .marginbig { display: flex; flex-direction: column; justify-content: center; height: 100vh; }
        .custom-btn { background-color: gray; color: black; border: none; }
        .custom-btn:hover { background-color: darkred; color: white; }
        .full-height { min-height: 87vh; display: flex; flex-direction: column; justify-content: center; }
        .text-large { font-size: 1.5em; text-align: center; }
        .footer { margin-top: auto; }
    </style>
</head>

<body>
@include('layouts.navbar')

<div class="container text-white">
    <h1>Płatność zakończona sukcesem!</h1>
    <p>Dziękujemy za dokonanie płatności.</p>
    @if(count($latestLoanMovies) > 0)
        <h2>Filmy z ostatniego wypożyczenia:</h2>
        <div class="row">
            @foreach($latestLoanMovies as $movie)
                <div class="col-md-3">
                    <div class="card bg-dark text-white m-3">
                        <img src="{{ route('movies.image', ['id' => $movie->id]) }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h6 class="card-title text-danger2"><b>{{ $movie->title }}</b></h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <h2>Zaraz wrócisz na stronę główną.</h2>
</div>


@include('layouts.footer', ['fixedBottom' => false])
</body>
</html>
