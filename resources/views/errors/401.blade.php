@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - 401'])
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
            justify-content: center;  // Centruje treść na stronie
        }

        .footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
@include('layouts.navbar')

<div class="container mt-5 mb-5">
    <div class="row mt-4 mb-4 text-center card">
        <h1 class="display-1 fw-bold">401</h1>
        <h2>
            @if (App::environment('local'))
                {{ $exception->getMessage() ?: 'Brak autoryzacji.' }}
            @else
                Brak autoryzacji.
            @endif
        </h2>
    </div>
    @include('layouts.validation-error')
</div>

@include('layouts.footer', ['fixedBottom' => false])
<script>
    document.getElementById("navbar-user").remove();
</script>
</body>
</html>
