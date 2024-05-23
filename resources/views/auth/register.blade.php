@include('layouts.html')

@include('layouts.head', ['pageTitle' => 'RentalVOD - rejestracja'])
<head>
    <style>
        .marginbig {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 85vh;
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
    </style>
</head>

<body>
    @include('layouts.navbar')
    
    <div class="container mt-5 mb-5 marginbig">
        <div class="row mt-4 mb-4 text-center">
            <div class="col-12">
                <img src="{{ asset('storage/img/logo.webp') }}" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px; border-radius: 50">
                <h1>Zarejestruj się</h1>
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
    
        <div class="row d-flex justify-content-center">
            <div class="col-10 col-sm-10 col-md-6 col-lg-4">
                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group mb-2">
                        <label for="first_name" class="form-label">Imię</label>
                        <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="last_name" class="form-label">Nazwisko</label>
                        <input id="last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="address" class="form-label">Adres</label>
                        <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Hasło</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="referral_code" class="form-label">Kod polecający (opcjonalnie)</label>
                        <input id="referral_code" name="referral_code" type="text" class="form-control">
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <button class="btn custom-btn" type="submit">Zarejestruj</button>
                    </div>
                </form>                                             
            </div>
        </div>
    </div>

@include('layouts.footer', ['fixedBottom' => false])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form.needs-validation');
        form.addEventListener('submit', function (event) {
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');
            let valid = true;
    
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Hasła nie są identyczne.');
                valid = false;
            } else {
                passwordConfirm.setCustomValidity('');
            }
    
            if (!valid) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
    
</body>
</html>
