@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - Profil użytkownika'])
<head>
    <style>
        .marginbig { display: flex; flex-direction: column; justify-content: center; height: 100vh; }
        .custom-btn { background-color: gray; color: black; border: none; }
        .custom-btn:hover { background-color: darkred; color: white; }
        .full-height { min-height: 87vh; display: flex; flex-direction: column; justify-content: center; }
        .text-large { font-size: 1.5em; text-align: center; }
        .footer { margin-top: auto; }
        .img-fluid { max-width: 100%; height: auto; }
        .table th, .table td {
            padding: 8px; 
            text-align: center;
            vertical-align: middle;
        }
        .table th:last-child, .table td:last-child {
            width: 30%; 
        }
        textarea {
            width: 100%; 
            height: 100px; 
        }
        .img { width: 100px; }
        .date-input { max-width: 150px; }
        .btn-info:hover{
            background-color: #0080ff;
        }
        .needs-validation{
            width: 50%;
        }
        .photo{
            width: 50%;
            display: flex;
            gap: 20px;
        }
    </style>
</head>
<body style="overflow-x: hidden;">
@include('layouts.navbar')

<div class="row mt-4 mb-4 text-center" style="text-align: center;">
    <div class="col-12" style="    display: flex;
    flex-direction: column;
    align-items: center;">
        <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
        <h1>Twój profil</h1>
    </div>
</div>

@if (Auth::check())
<div class="container mt-5 marginbig">
    <div class="card">
        <div class="card-header" style="padding: 20px;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <!-- Header content -->
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h1>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Adres:</strong> {{ Auth::user()->address }}, {{ Auth::user()->city }}</p>
                    <div>
                        <a href="{{ route('settings') }}" class="btn custom-btn btn-test">Edytuj dane</a>
                        <a href="{{ route('cart.show') }}" class="btn custom-btn btn-test">Koszyk</a>
                        <a href="{{ route('logout') }}" class="btn custom-btn btn-test">Wyloguj</a>
                    </div>
                </div>
    
                <!-- Photo section -->
                <div class="photo text-center">
                    <img src="{{ url(Auth::user() ? Auth::user()->avatar : 'storage/img/user.png') }}" class="rounded-circle" height="100" alt="Portrait of a User" loading="lazy"/>
                    {{-- <img src="{{ asset('storage/avatars/' . basename(Auth::user()->avatar)) }}"" class="rounded-circle" height="100" alt="Portrait of a User" loading="lazy"/> --}}
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

    <h3>Aktualne wypożyczenia:</h3>
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
                        <th>Dodaj opinię</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        @foreach ($loan->movies as $movie)
                        <tr>
                            <td>
                                @if ($loan->status !== 'zwrócone')
                                    <a href="{{ route('loans.show', $movie->id) }}">{{ $movie->title }}</a>
                                @else
                                    {{ $movie->title }}
                                @endif
                            </td>
                            <td>{{ $loan->start }}</td>
                            <td>{{ $loan->end }}</td>
                            <td>{{ number_format($loan->price, 2) }} zł</td>
                            <td>{{ $loan->status }}</td>
                            <td>
                                <button onclick="toggleReviewForm({{ $loan->id }})" class="btn btn-info">Dodaj opinię</button>
                                <div id="review-form-{{ $loan->id }}" style="display:none;">
                                    <form action="{{ route('opinions.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <textarea name="content" placeholder="Wpisz swoją opinię" required></textarea>
                                        <button type="submit" class="btn btn-primary">Wyślij</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach            
                </tbody>
            </table>        
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
<script>
    function toggleReviewForm(loanId) {
        var form = document.getElementById('review-form-' + loanId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function (event) {
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
</body>
</html>
