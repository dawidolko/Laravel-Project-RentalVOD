@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - ustawienia konta'])
<head>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            position: relative;
            width: 100%;
            clear: both;
        }
        .custom-btn {
            background-color: gray;
            color: black;
            border: none;
        }
        .custom-btn:hover {
            background-color: darkred;
            color: white;
        }
        .container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .full-height {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .text-large {
            font-size: 1.5em;
            text-align: center;
        }
    </style>
</head>

<body>
@include('layouts.navbar')

@if (Auth::check())
<div class="container mt-5 mb-5 marginbig">
    @include('layouts.session-error')

    <div class="row mt-4 mb-4 text-center">
        <div class="col-12">
            <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
            <h1>Ustawienia konta</h1>
        </div>
    </div>

    <div class="container mt-5 mb-5">
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
        
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
    
                <form method="POST" action="{{ route('user.update') }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Ulica</label>
                        <input id="address" name="address" type="text" class="form-control" value="{{ Auth::user()->address }}" required>
                    </div>
                    <div class="text-center mb-3">
                        <button type="submit" class="btn custom-btn">Zapisz zmiany adresu</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('user.update_avatar') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
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
    

    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
    
                <form method="POST" action="{{ route('user.change_password') }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="current_password" class="form-label">Obecne Hasło</label>
                        <input id="current_password" name="current_password" type="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password" class="form-label">Nowe Hasło</label>
                        <input id="new_password" name="new_password" type="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password_confirmation" class="form-label">Potwierdzenie Nowego Hasła</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn custom-btn">Zmień hasło</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@else
    <div class="full-height">
        <p class="text-large">Proszę się zalogować, aby uzyskać dostęp do ustawień konta.</p>
    </div>
@endif

@include('layouts.footer', ['fixedBottom' => false])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const settingsForm = document.querySelector('.needs-validation');
        settingsForm.addEventListener('submit', function (event) {
            const address = document.getElementById('address');
            let valid = true;
    
            if (!address.value.match(/^[a-zA-Z0-9\s,.-]+$/)) {
                valid = false;
                alert('Adres może zawierać tylko litery, cyfry, spacje oraz znaki ,.-');
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
