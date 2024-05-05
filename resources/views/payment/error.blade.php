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
    <h1 class="text-danger">Błąd płatności</h1>
    <p>Przepraszamy, wystąpił błąd podczas przetwarzania płatności.</p>
    <p>{{ session('error') }}</p>
    <a href="/users/{{ Auth::id() }}" class="btn custom-btn">Opłać na swoim profilu</a>
</div>

@include('layouts.footer', ['fixedBottom' => false])
</body>
</html>
