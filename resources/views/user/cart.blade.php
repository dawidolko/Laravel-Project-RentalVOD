@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - koszyk'])
<head>
    <link rel="stylesheet" href="{{ asset('css/movieStyle.css') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .marginbig { display: flex; flex-direction: column; justify-content: center; }
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
        .payment-section { margin-top: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 20px; }
    </style>
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
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </ul>
        </div>
        @endif

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
                                            <button type="submit" class="btn btn-info">Aktualizuj daty</button>
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
                <div class="text-right" style="padding: 20px; display: flex; justify-content: center;">
                    @if ($canRentForFree)
                        <div class="alert alert-info" role="alert">
                            Masz wystarczająco punktów, aby wypożyczyć film za darmo! Przy płatności zostanie odjęte 50 punktów.
                        </div>
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <input type="hidden" name="usePoints" value="1">
                            <button type="submit" class="btn custom-btn">Wypożycz za darmo</button>
                        </form>
                    @else
                        <button id="checkout-button" class="btn custom-btn" onclick="handleCheckout()">Przejdź do płatności</button>
                    @endif
                </div>
                <!-- Payment section -->
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
                        <button type="submit" class="btn btn-primary">Zapłać</button>
                    </form>                                      
                </div>
            </div>
            @else
            <div class="alert alert-danger" role="alert">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const todayString = today.toISOString().split('T')[0];
            const dateInputs = document.querySelectorAll('.date-input');
        
            dateInputs.forEach(input => {
                if (input.name === 'start') {
                    input.min = todayString;
                }
                input.addEventListener('change', function() {
                    const row = input.closest('tr');
                    const startDateInput = row.querySelector('input[name="start"]');
                    const endDateInput = row.querySelector('input[name="end"]');
                    if (startDateInput && startDateInput.value) {
                        endDateInput.min = startDateInput.value;
                        let maxDate = new Date(startDateInput.value);
                        maxDate.setDate(maxDate.getDate() + 13);
                        endDateInput.max = maxDate.toISOString().split('T')[0];
                    }
                    updateCost(row);
                });
            });
        
            document.getElementById('checkout-button').addEventListener('click', function(event) {
                if (!areDatesComplete()) {
                    event.preventDefault();
                    alert('Proszę wypełnić wszystkie daty startowe i końcowe!');
                } else {
                    document.getElementById('payment-section').style.display = 'block';
                }
            });
        
            function updateCost(row) {
                const startDateInput = row.querySelector('input[name="start"]');
                const endDateInput = row.querySelector('input[name="end"]');
                const pricePerDay = parseFloat(row.querySelector('.price-per-day').textContent.replace(' zł', ''));
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    const diffTime = endDate - startDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    const totalCost = pricePerDay * diffDays;
                    row.querySelector('.total-cost').textContent = `${totalCost.toFixed(2)} zł`;
                } else {
                    row.querySelector('.total-cost').textContent = '0 zł';
                }
                updateTotal();
            }
        
            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.total-cost').forEach(item => {
                    const itemCost = parseFloat(item.textContent.replace(' zł', ''));
                    total += itemCost;
                });
                document.getElementById('total-display').textContent = `Razem: ${total.toFixed(2)} zł`;
            }
        
            function areDatesComplete() {
                return Array.from(document.querySelectorAll('.date-input')).every(input => input.value !== '');
            }
        
            const expiryDateInput = document.getElementById('expiryDate');
            expiryDateInput.min = new Date().toISOString().slice(0, 7);
        });
    </script>
</body>
</html>
