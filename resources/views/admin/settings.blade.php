@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - admin settings'])

<head>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styleSettings.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navbar')

    <div class="container">
        <h1 style="margin-top:50px; text-align:center;">Ustawienia rekomendacji</h1>

        @include('layouts.success')

        @include('layouts.errors')

        <form action="{{ route('admin.updateRule') }}" method="POST">
            @csrf
            <div class="form-group" style="text-align:center;">
                <label for="rate" style="text-align:center;">Minimalna ocena filmu:</label>
                <input style="text-align:center;" type="number" id="rate" name="rate" class="form-control" value="{{ old('rate', $currentRate) }}" min="0" max="10" step="0.1" required>
            </div>
            <div class="form-group" style="text-align:center; margin-top:20px;">
                <label for="recommendations_count" style="text-align:center;">Minimalna liczba rekomendacji:</label>
                <input style="text-align:center;" type="number" id="recommendations_count" name="recommendations_count" class="form-control" value="{{ old('recommendations_count', $currentRecommendationsCount) }}" min="0" max="1000" required>
            </div>
            <div style="display: flex; justify-content: space-around; margin-top:20px;">
                <button type="submit" style="padding: 10px; border-radius:5px;" class="btn-block custom-btn mt-2">Zaktualizuj Zasadę</button>
            </div>
        </form>

        <h1 style="margin-top:50px; text-align:center;">Ustawienia promocji</h1>
        <form style="display: flex; justify-content: space-around;" action="{{ route('admin.togglePromotions') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" style="padding: 10px; border-radius:5px;" class="btn-block custom-btn">
                {{ $promotionsEnabled ? 'Wyłącz Promocje' : 'Włącz Promocje' }}
            </button>
        </form>
    </div>
    @include('layouts.footer', ['fixedBottom' => false])
</body>

</html>
