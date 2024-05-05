
@include('layouts.html')
  
  @include('layouts.slider')
  @include('layouts.head', ['pageTitle' => 'RentalVOD - strona główna'])
  <head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}" />
<style>
    .list-group-item {
        flex-wrap: wrap;
    }

    @media (max-width: 576px) {
        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .list-group-item .text-white {
            margin-bottom: 1rem;
        }

        .list-group-item .wrap {
            margin-top: 1rem;
        }
    }
</style>
</head>
<body>
  @include('layouts.navbar')

{{-- <div class="container w-100">
    <ul class="list-group">
        @if ($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong>
            @endforeach
        </div>
        @elseif (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif
        @foreach($users as $key => $user)
        <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white">
            <div class="text-white">
                <span class="fw-bold">{{ $user->id }}</span>
                <span class="fw-bold">{{ $user->first_name }}</span>
                <span class="fw-bold">{{ $user->last_name }}</span>
                <span class=""> |  Email: {{ $user->email }}</span>
                <span class=""> |  Adres: {{ $user->city }}, {{ $user->address }}</span>
            </div>
            <div>
                <a href="#" class="btn btn-secondary custom-btn" onclick="toggleEditPanel(event, {{ $user->id }})">Edytuj</a>

                <a href="{{ route('users.delete', ['id' => $user->id]) }}" class="btn btn-danger @foreach ($loans as $loan) @if ($user->id == $loan->user_id) disabled @endif @endforeach" >Usuń</a>
            </div>
        </li>
        <li id="edit-panel-{{ $user->id }}" class="list-group-item bg-dark text-white edit-panel" style="display: none;">
            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="first_name">Imie</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required value="{{ $user->first_name }}">
                </div>
                <div class="form-group">
                    <label for="last_name">Nazwisko</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required value="{{ $user->last_name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="address">Adres</label>
                    <input type="text" class="form-control" id="address" name="address" required value="{{ $user->address }}">
                </div>
                <div class="form-group">
                    <label for="city">Miasto</label>
                    <input type="text" class="form-control" id="city" name="city" required value="{{ $user->city }}">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="admin" name="admin" @if($user->isAdmin == 1) checked @endif>
                    <label class="form-check-label" for="admin">Administrator</label>
                </div>
                <button type="submit" class="btn btn-secondary m-2 w-30">Zapisz</button>
            </form>
        </li>
    @endforeach
    </ul>
</div> --}}
@include('layouts.footer', ['fixedBottom' => false])
<script defer src="{{ asset('js/magnification.js') }}"></script>
</body>
</html>
