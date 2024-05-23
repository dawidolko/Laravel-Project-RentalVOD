@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - profil użytkownika'])
<head>
    <style>
        .marginbig { display: flex; flex-direction: column; justify-content: center; height: 100vh; }
        .custom-btn { background-color: gray; color: black; border: none; }
        .custom-btn:hover { background-color: darkred; color: white; }
        .full-height { min-height: 87vh; display: flex; flex-direction: column; justify-content: center; }
        .text-large { font-size: 1.5em; text-align: center; }
        .footer { margin-top: auto; }
        .img-fluid { max-width: 100%; height: auto; }
        .table th, .table td { padding: 8px; text-align: center; vertical-align: middle; }
        .table th:last-child, .table td:last-child { width: 30%; }
        textarea { width: 100%; height: 100px; }
        .img { width: 100px; }
        .date-input { max-width: 150px; }
        .btn-info:hover { background-color: #0080ff; }
        .needs-validation { width: 50%; }
        .photo { width: 50%; display: flex; gap: 20px; }
        .disabled-link { color: gray; text-decoration: none; cursor: default; }
    </style>
</head>
<body style="overflow-x: hidden;">
@include('layouts.navbar')

<div class="row mt-4 mb-4 text-center" style="text-align: center;">
    <div class="col-12" style="display: flex; flex-direction: column; align-items: center;">
        <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
        <h1>Twój profil</h1>
    </div>
</div>

@if (Auth::check())
<div class="container mt-5">

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

    <div id="snackbar"></div>


    <div class="card">
        <div class="card-header" style="padding: 20px;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h1>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Adres:</strong> {{ Auth::user()->address }}</p>
                    <p><strong>Punkty lojalnościowe:</strong> {{ Auth::user()->loyaltyPoints->points ?? 0 }}</p>
                    <p><strong>Kod polecający:</strong> {{ $referralCode }}</p>
                    <div>
                        <a href="{{ route('settings') }}" class="btn custom-btn btn-test">Edytuj dane</a>
                        <a href="{{ route('cart.show') }}" class="btn custom-btn btn-test">Koszyk</a>
                        <a href="{{ route('logout') }}" class="btn custom-btn btn-test">Wyloguj</a>
                    </div>
                </div>
                <div class="photo text-center">
                    <img src="{{ url(Auth::user() ? Auth::user()->avatar : 'storage/img/user.png') }}" class="rounded-circle" height="100" alt="Portrait of a User" loading="lazy" />
                    <form method="POST" action="{{ route('user.update_avatar') }}" enctype="multipart/form-data" class="needs-validation mt-3" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="avatar" class="form-label">Zmień awatar</label>
                            <input id="avatar" name="avatar" type="file" class="form-control" required>
                        </div>
                        <div class="text-center mb-3">
                            <button type="submit" class="btn custom-btn">Zaktualizuj awatar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h3 style="margin-top:20px;">Wydatki w poszczególnych dniach:</h3>
    <div class="chart-container" style="position: relative; height:40vh; width:80vw; margin-bottom: 20px;">
        <canvas id="expensesChart"></canvas>
    </div>
    <div class="d-flex justify-content-between mb-4">
        <button id="prevWeek" class="btn custom-btn">Poprzedni tydzień</button>
        <button id="nextWeek" class="btn custom-btn">Następny tydzień</button>
    </div>

    <h3 style="margin-top:20px;">Aktualne wypożyczenia:</h3>
    @if($loans->isEmpty())
    <div class="alert alert-danger" role="alert">
        BRAK WYPOŻYCZONYCH FILMÓW
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered text-white">
            <thead>
                <tr>
                    <th>Film</th>
                    <th>Data rozpoczęcia</th>
                    <th>Data zakończenia</th>
                    <th>Cena całkowita</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                @foreach ($loan->movies as $movie)
                <tr>
                    <td>
                        @php
                        $premiumMovie = \App\Models\PremiumMovie::where('movie_id', $movie->id)
                                                             ->where('user_id', auth()->id())
                                                             ->first();
                        @endphp
                        @if ($loan->status !== 'zwrócone')
                            @if ($premiumMovie)
                            <a href="{{ route('loans.premium', $movie->id) }}">{{ $movie->title }}</a>
                            @else
                            <a href="{{ route('loans.show', $movie->id) }}">{{ $movie->title }}</a>
                            @endif
                        @else
                            <span class="disabled-link">{{ $movie->title }}</span>
                        @endif
                    </td>
                    <td>{{ $loan->start }}</td>
                    <td>{{ $loan->end }}</td>
                    <td>{{ number_format($loan->price, 2) }} zł</td>
                    <td>{{ $loan->status }}</td>
                    <td>
                        @php
                        $existingOpinion = \App\Models\Opinion::where('movie_id', $movie->id)
                                                             ->where('user_id', auth()->id())
                                                             ->first();
                        @endphp
                        @if ($existingOpinion)
                        <p>Już dodałeś opinię dla tego filmu.</p>
                        @else
                        <button onclick="toggleReviewForm({{ $loan->id }})" class="btn btn-info">Dodaj opinię</button>
                        <div id="review-form-{{ $loan->id }}" style="display:none;">
                            <form action="{{ route('opinions.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <textarea name="content" placeholder="Wpisz swoją opinię" required></textarea>
                                <button type="submit" class="btn btn-primary">Wyślij</button>
                            </form>
                        </div>
                        @endif
                        @if ($premiumMovie)
                        <p>Jakość premium odblokowana.</p>
                        @elseif ($loan->status !== 'zwrócone')
                        <button onclick="togglePaymentForm({{ $loan->id }})" class="btn btn-warning" style="margin-top:10px;">Kup jakość premium</button>
                        @if (Auth::user()->loyaltyPoints->points >= 50)
                        <form method="POST" action="{{ route('user.upgradeToPremium', $movie->id) }}" id="points-form-{{ $loan->id }}">
                            @csrf
                            <button type="submit" class="btn btn-success" style="margin-top:10px;">Kup jakość premium za punkty</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('user.upgradeToPremium', $movie->id) }}" id="payment-form-{{ $loan->id }}" style="display:none;">
                            @csrf
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title">Dane karty kredytowej</h5>
                                    <div class="mb-3">
                                        <label for="cardNumber" class="form-label">Numer karty</label>
                                        <input type="text" id="cardNumber-{{ $loan->id }}" name="cardNumber" class="form-control" pattern="\d{16}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expiryDate" class="form-label">Data ważności</label>
                                        <input type="month" id="expiryDate-{{ $loan->id }}" name="expiryDate" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" id="cvv-{{ $loan->id }}" name="cvv" class="form-control" pattern="\d{3}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Zapłać</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $loans->links('pagination::bootstrap-4') }}
        </div>
    </div> 
    @endif
</div>
@else
<div class="full-height">
    <p class="text-large">Proszę się zalogować, aby uzyskać dostęp do profilu.</p>
    <div class="text-center">
        <a href="{{ route('login') }}" class="btn custom-btn">Zaloguj się</a>
    </div>
</div>
@endif

@include('layouts.footer', ['fixedBottom' => false])
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('expensesChart').getContext('2d');
        const expensesData = @json($expensesData);

        let currentWeekIndex = 0;
        const weeks = chunkArray(expensesData, 7);

        function updateChart(weekIndex) {
            const weekData = weeks[weekIndex] || [];
            const labels = weekData.map(day => day.date);
            const data = weekData.map(day => day.amount);

            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();

            document.getElementById('prevWeek').style.display = weekIndex > 0 ? 'block' : 'none';
            document.getElementById('nextWeek').style.display = weekIndex < weeks.length - 1 ? 'block' : 'none';
        }

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Wydatki (zł)',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('prevWeek').addEventListener('click', function() {
            if (currentWeekIndex > 0) {
                currentWeekIndex--;
                updateChart(currentWeekIndex);
            }
        });

        document.getElementById('nextWeek').addEventListener('click', function() {
            if (currentWeekIndex < weeks.length - 1) {
                currentWeekIndex++;
                updateChart(currentWeekIndex);
            }
        });

        function chunkArray(array, size) {
            const result = [];
            for (let i = 0; i < array.length; i += size) {
                result.push(array.slice(i, i + size));
            }
            return result;
        }

        updateChart(currentWeekIndex);
    });
</script>
<script>
    function toggleReviewForm(loanId) {
        var form = document.getElementById('review-form-' + loanId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function togglePaymentForm(loanId) {
        var form = document.getElementById('payment-form-' + loanId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('[id^="payment-form-"]');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                const expiryDateInput = form.querySelector('[name="expiryDate"]');
                const expiryDateValue = expiryDateInput.value;
                const currentDate = new Date();
                const expiryDate = new Date(expiryDateValue + '-01');

                if (expiryDate < currentDate) {
                    event.preventDefault();
                    alert('Data ważności karty nie może być z przeszłości.');
                }
            });

            const expiryDateInput = form.querySelector('[name="expiryDate"]');
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
            const minExpiryDate = `${currentYear}-${currentMonth}`;
            expiryDateInput.min = minExpiryDate;
        });

        const avatarForm = document.querySelector('.needs-validation');
        avatarForm.addEventListener('submit', function(event) {
            const fileInput = document.getElementById('avatar');
            let valid = true;

            if (fileInput.files.length === 0) {
                valid = false;
                fileInput.classList.add('is-invalid');
            } else {
                fileInput.classList.remove('is-invalid');
            }

            if (!valid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('expensesChart').getContext('2d');
        const expensesData = @json($expensesData);

        let currentWeekIndex = 0;
        const weeks = chunkArray(expensesData, 7);

        function updateChart(weekIndex) {
            const weekData = weeks[weekIndex] || [];
            const labels = weekData.map(day => day.date);
            const data = weekData.map(day => day.amount);

            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();

            document.getElementById('prevWeek').style.display = weekIndex > 0 ? 'block' : 'none';
            document.getElementById('nextWeek').style.display = weekIndex < weeks.length - 1 ? 'block' : 'none';
        }

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Wydatki (zł)',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('prevWeek').addEventListener('click', function() {
            if (currentWeekIndex > 0) {
                currentWeekIndex--;
                updateChart(currentWeekIndex);
            }
        });

        document.getElementById('nextWeek').addEventListener('click', function() {
            if (currentWeekIndex < weeks.length - 1) {
                currentWeekIndex++;
                updateChart(currentWeekIndex);
            }
        });

        function chunkArray(array, size) {
            const result = [];
            for (let i = 0; i < array.length; i += size) {
                result.push(array.slice(i, i + size));
            }
            return result;
        }

        updateChart(currentWeekIndex);
    });
</script>
<script>
    function toggleReviewForm(loanId) {
        var form = document.getElementById('review-form-' + loanId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function togglePaymentForm(loanId) {
        var form = document.getElementById('payment-form-' + loanId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('[id^="payment-form-"]');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                const expiryDateInput = form.querySelector('[name="expiryDate"]');
                const expiryDateValue = expiryDateInput.value;
                const currentDate = new Date();
                const expiryDate = new Date(expiryDateValue + '-01');

                if (expiryDate < currentDate) {
                    event.preventDefault();
                    alert('Data ważności karty nie może być z przeszłości.');
                }
            });

            const expiryDateInput = form.querySelector('[name="expiryDate"]');
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
            const minExpiryDate = `${currentYear}-${currentMonth}`;
            expiryDateInput.min = minExpiryDate;
        });

        const avatarForm = document.querySelector('.needs-validation');
        avatarForm.addEventListener('submit', function(event) {
            const fileInput = document.getElementById('avatar');
            let valid = true;

            if (fileInput.files.length === 0) {
                valid = false;
                fileInput.classList.add('is-invalid');
            } else {
                fileInput.classList.remove('is-invalid');
            }

            if (!valid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
</script>

<script>
    // Snackbar logic
    function showSnackbar(message) {
        var snackbar = document.getElementById("snackbar");
        snackbar.innerHTML = message;
        snackbar.className = "show";
        setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 8000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('points_message'))
            showSnackbar("{{ session('points_message') }}");
        @endif
    });
</script>

<style>
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #720e0e;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
    }
</style>
</body>
</html>
