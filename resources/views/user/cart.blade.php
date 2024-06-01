@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - koszyk'])

<head>
    <link rel="stylesheet" href="{{ asset('css/movieStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleCart.css') }}">
</head>

<body>
    @include('layouts.navbar')

    @if (Auth::check())
    @php
    $user = Auth::user();
    $loyaltyPoints = $user->loyaltyPoints->points ?? 0;
    $canRentForFree = $loyaltyPoints >= 50;
    @endphp

    <div class="container mt-5">
        <div class="row mt-4 mb-4 text-center" style="text-align: center;">
            <div class="col-12" style="display: flex; flex-direction: column; align-items: center;">
                <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
            </div>
        </div>
        @include('layouts.success')
        @include('layouts.errors')

        @php $total = 0; @endphp
        @php $cart = session('cart', []); @endphp
        @if (count($cart) > 0)
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Koszyk</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Obraz</th>
                                <th>Nazwa produktu</th>
                                <th>Cena za dzień</th>
                                <th>Data rozpoczęcia</th>
                                <th>Data zakończenia</th>
                                <th>Całkowity koszt</th>
                                <th>Przycisk do aktualizacji dat</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $id => $details)
                            @php
                            $startDate = new DateTime($details['start'] ?? now());
                            $endDate = new DateTime($details['end'] ?? now());
                            $diff = $startDate > $endDate ? 0 : $startDate->diff($endDate)->days + 1;
                            $subTotal = $details['price'] * $diff;
                            $total += $subTotal;
                            @endphp
                            <tr>
                                <td><img src="{{ asset($details['image']) }}" alt="Product Image" class="img img-fluid" width="50"></td>
                                <td>{{ $details['name'] }}</td>
                                <td class="price-per-day">{{ $details['price'] }} zł</td>
                                <td>
                                    <input type="date" form="update-form-{{ $id }}" name="start" class="date-input" value="{{ $details['start'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="date" form="update-form-{{ $id }}" name="end" class="date-input" value="{{ $details['end'] ?? '' }}">
                                </td>
                                <td class="total-cost">{{ number_format($subTotal, 2) }} zł</td>
                                <td>
                                    <form id="update-form-{{ $id }}" action="{{ route('cart.update', ['movie_id' => $id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Aktualizuj daty</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right"><strong id="total-display">Razem: 0 zł</strong></div>
                <div class="text-right" style="padding: 20px; display: flex; flex-direction: column;align-items: center;">
                    @if ($canRentForFree)
                    <div class="alert alert-info" role="alert">
                        Masz wystarczająco punktów, aby wypożyczyć film za darmo! Przy płatności zostanie odjęte 50 punktów.
                    </div>
                    <div>
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <input type="hidden" name="usePoints" value="1">
                            <button type="submit" class="btn btn-success btn-sm">Wypożycz za darmo</button>
                        </form>
                    </div>
                    @else
                    <button id="checkout-button" class="btn custom-btn" onclick="handleCheckout()">Przejdź do płatności</button>
                    @endif
                </div>
                <div class="payment-section" id="payment-section" style="display: none; margin-bottom: 150px;">
                    <h3>Informacje o płatności</h3>
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <input type="hidden" name="total" value="{{ $total }}">
                        <div class="mb-3">
                            <label for="cardNumber">Numer karty</label>
                            <input type="text" id="cardNumber" name="cardNumber" required pattern="\d{16}" class="form-control" placeholder="Numer karty (16 cyfr)">
                        </div>
                        <div class="mb-3">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" required pattern="\d{3}" class="form-control" placeholder="CVV (3 cyfry)">
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate">Data ważności</label>
                            <input type="month" id="expiryDate" name="expiryDate" required class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Zapłać</button>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-info" role="alert">
                KOSZYK JEST PUSTY
            </div>
            @endif
        </div>
        @else
        <div class="full-height">
            <p class="text-large">Proszę się zalogować, aby uzyskać dostęp do koszyka.</p>
            <div class="text-center">
                <a href="{{ route('login') }}" class="btn custom-btn">Zaloguj się</a>
            </div>
        </div>
        @endif
    </div>

    @include('layouts.footer', ['fixedBottom' => false])
    <script src="{{ asset('js/cart.js') }}"></script>
</body>

</html>
