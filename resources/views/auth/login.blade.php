@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - Logowanie'])
<head>
    <style>
        .marginbig {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 81vh;
        }
        .marginbig {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 81vh;
        }
        .custom-btn {
            background-color: gray;
            color: black;
            border: none;  /* Usuwa domyślną ramkę przycisku */
        }
        .custom-btn:hover {
            background-color: darkred;
            color: white;
        }
    </style>
</head>
<body>
@include('layouts.navbar')

<div class="container mt-5 mb-5 marginbig">
    @include('layouts.session-error')

    <div class="row mt-4 mb-4 text-center">
        <div class="col-12">
            <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
            <h1>Zaloguj się</h1>
        </div>
    </div>

    @include('layouts.validation-error')

    <div class="row d-flex justify-content-center">
        <div class="col-10 col-sm-10 col-md-6 col-lg-4">
            <form method="POST" action="{{ route('login.authenticate') }}" class="needs-validation" novalidate>
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Hasło</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                    <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
                </div>
                
                <div class="text-center mt-4 mb-4">
                    <button class="btn custom-btn" type="submit">Zaloguj się</button>
                </div>
                <p>Nie masz konta? <a href="{{ route('register') }}">Zarejestruj się</a></p>
            </form>
        </div>
    </div>
</div>


    @include('layouts.footer', ['fixedBottom' => false])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function (event) {
                let valid = true;
                const email = document.getElementById('email');
                const password = document.getElementById('password');
        
                // Prosta walidacja e-mail
                if (!email.value.includes('@') || !email.value.includes('.')) {
                    valid = false;
                    email.classList.add('is-invalid');
                } else {
                    email.classList.remove('is-invalid');
                }
        
                // Prosta walidacja hasła
                if (password.value.length < 8) {
                    valid = false;
                    password.classList.add('is-invalid');
                } else {
                    password.classList.remove('is-invalid');
                }
        
                if (!valid) {
                    event.preventDefault(); 
                }
            });
        });
    </script>
        
</body>
</html>