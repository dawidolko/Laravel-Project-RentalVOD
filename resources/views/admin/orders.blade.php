@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - admin orders'])

<head>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .footer {
            margin-top: auto; 
        }

        .chart-container {
            position: relative;
            width: 80%;
            max-width: 600px;
            height: 400px;
            margin: auto;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            --bs-table-bg: var(--bs-table-striped-bg);
            background-color: var(--bs-table-striped-bg);
        }
    </style>
</head>

<body>
@include('layouts.navbar')

<div class="container mt-4">
    <div class="chart-container">
        <h3 class="text-center">Wykres ceny zamówienia na tle innych</h3>
        <canvas id="priceHistogram"></canvas> 
    </div>
    <h1 class="mt-4">Wszystkie zamówienia</h1>
    <div class="table-responsive"> 
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Zdjęcie</th>
                <th>Tytuł filmu</th>
                <th>Cena całkowita</th>
                <th>Email</th>
                <th>Czas rozpoczęcia</th>
                <th>Czas zakończenia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
                @foreach ($loan->movies as $movie)
                <tr>
                    <td><img src="{{ asset('storage/'.$movie->img_path) }}" alt="Obrazek filmu" class="img-fluid" style="width: 100px;"></td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $loan->price }} PLN</td>
                    <td>{{ $loan->user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->start)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->end)->format('Y-m-d') }}</td>
                    <td>{{ $loan->status }}</td>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const prices = @json($loans->getCollection()->pluck('price')->toArray());

        const ctx = document.getElementById('priceHistogram').getContext('2d');
        const priceHistogram = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: prices.map((price, index) => `Zamówienie ${index + 1}`), 
                datasets: [{
                    label: 'Rozkład cen zamówień',
                    data: prices, 
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cena (PLN)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Zamówienia'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.raw} PLN`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    function showForm(id) {
        var form = document.getElementById('form-' + id);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

@include('layouts.footer', ['fixedBottom' => false])
<script defer src="{{ asset('js/magnification.js') }}"></script>
</body>
</html>
