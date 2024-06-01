@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - 500'])

<head>
    <link rel="stylesheet" href="{{ asset('css/styleError.css') }}">
</head>

<body>
    @include('layouts.navbar')

    <div class="container mt-5 mb-5">
        <div class="row mt-4 mb-4 text-center card">
            <h1 class="display-1 fw-bold">500</h1>
            <h2>
                @if (App::environment('local'))
                {{ $exception->getMessage() ?: 'Błąd wewnętrzny serwera.' }}
                @else
                Błąd wewnętrzny serwera.
                @endif
            </h2>
            <p>Jeśli problem będzie się powtarzał, skontaktuj się z pomocą techniczną lub <a href="{{ url('/') }}">wróć na stronę główną</a>.</p>
        </div>
        @include('layouts.validation-error')
    </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script>
        document.getElementById("navbar-user").remove();

    </script>
</body>

</html>
