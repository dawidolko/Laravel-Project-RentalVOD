{{-- @include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - Checkout'])

<head>
    <link rel="stylesheet" href="{{ asset('css/movieStyle.css') }}">
    <style>
        .marginbig { display: flex; flex-direction: column; justify-content: center; height: 100vh; }
        .custom-btn { background-color: gray; color: black; border: none; }
        .custom-btn:hover { background-color: darkred; color: white; }
        .full-height { min-height: 87vh; display: flex; flex-direction: column; justify-content: center; }
        .text-large { font-size: 1.5em; text-align: center; }
        .footer { margin-top: auto; }
        .img-fluid { max-width: 100%; height: auto; }
        .table { width: 100%; }
        th, td { padding: 15px; text-align: center; }
        .img { width: 100px; }
        .date-input { max-width: 150px; }
    </style>
</head>

<body>
@include('layouts.navbar')

@if (Auth::check())
    <div class="container mt-5 marginbig">
        <h2>Podsumowanie zamówienia</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Cena za dzień</th>
                    <th>Ilość dni</th>
                    <th>Całkowity koszt</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach (session('cart', []) as $id => $details)
                    @php
                        \Log::info('Cart item details:', $details); // Log the details
                        if (!empty($details['start']) && !empty($details['end'])) {
                            $startDate = new DateTime($details['start']);
                            $endDate = new DateTime($details['end']);
                            $diff = $startDate->diff($endDate)->days + 1;
                            $subTotal = $details['price'] * $diff;
                            $total += $subTotal;
                        } else {
                            $diff = 0;
                            $subTotal = 0;
                        }
                    @endphp
                    <tr>
                        <td><img src="{{ asset($details['image']) }}" alt="Product Image" class="img img-fluid" width="50">{{ $details['name'] }}</td>
                        <td>{{ $details['price'] }} zł</td>
                        <td>{{ $diff }}</td>
                        <td>{{ $subTotal }} zł</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Suma:</strong></td>
                    <td><strong>{{ $total }} zł</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <div class="full-height">
        <p class="text-large">Proszę się zalogować, aby uzyskać dostęp do płatności.</p>
        <div class="text-center">
            <a href="{{ route('login') }}" class="btn custom-btn">Zaloguj się</a>
        </div>
    </div>
@endif

@include('layouts.footer', ['fixedBottom' => false])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();
        });

        function updateCartDisplay() {
            let total = 0;
            const tbody = document.querySelector('table.table tbody');
            tbody.innerHTML = ''; // Czyści obecne dane tabeli

            Object.keys(localStorage).forEach(key => {
                if(key.startsWith('cartItem-')) {
                    const item = JSON.parse(localStorage.getItem(key));
                    const row = `<tr>
                        <td><img src="${item.image}" alt="Product Image" class="img img-fluid" width="50">${item.name}</td>
                        <td>${item.pricePerDay} zł</td>
                        <td>${item.days}</td>
                        <td>${item.totalPrice.toFixed(2)} zł</td>
                    </tr>`;
                    tbody.innerHTML += row;
                    total += item.totalPrice;
                }
            });

            // Dodaj wiersz sumy
            const totalRow = `<tr>
                <td colspan="3" class="text-right"><strong>Suma:</strong></td>
                <td><strong>${total.toFixed(2)} zł</strong></td>
            </tr>`;
            tbody.innerHTML += totalRow;
        }
    </script>
</body>
</html> --}}
