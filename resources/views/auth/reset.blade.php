{{-- @include('layouts.html')
  
  @include('layouts.head', ['pageTitle' => 'RentalVOD - regulamin'])
  <body>
    @include('layouts.navbar', ['categories' => $categories])

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Zmień hasło</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group  text-white">
                                <label for="current_password">Aktualne hasło</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                @error('current_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <p></p>
                            </div>
    
                            <div class="form-group  text-white">
                                <label for="new_password">Nowe hasło</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                @error('new_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <p class="text-danger" id="newPw"></p>
                            </div>
    
                            <div class="form-group text-white">
                                <label for="confirm_password">Potwierdź nowe hasło</label>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password">
                                @error('confirm_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <p class="text-danger" id="confirmed"></p>
                            </div>
    
                            <button type="submit" class="btn custom-btn mt-2">Zmień hasło</button>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    window.location.href = "/users/{{ Auth::id() }}";
                                }, 2500);
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footer', ['fixedBottom' => false])
</body>
</html> --}}
