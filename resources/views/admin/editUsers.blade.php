@include('layouts.html')
@include('layouts.slider')
@include('layouts.head', ['pageTitle' => 'RentalVOD - Admin Users'])

<head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}">
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

        .container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .list-group-item {
            border-bottom: 1px solid #ccc;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .user-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        .user-info > span {
            margin-right: 15px;
            white-space: nowrap;
        }
        .button-group a {
            margin-right: 10px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .btn-secondary{
            margin-right: 10px;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
        <div class="container w-100">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h1>Wszyscy klienci</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Awatar</th>
                    <th style="text-align: center">Imię</th>
                    <th style="text-align: center">Nazwisko</th>
                    <th style="text-align: center">Email</th>
                    <th style="text-align: center">Adres</th>
                    <th style="text-align: center">Hasło</th>
                    <th style="text-align: center">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <!-- Dane użytkownika -->
                    <td>{{ $user->id }}</td>
                    <td><img src="{{ asset($user->avatar) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;"></td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->city }}, {{ $user->address }}</td>
                    <td>{{ str_repeat('*', 5) }}</td>
                    <td style="display: flex;">
                        <!-- Przycisk otwierający panel edycji -->
                        <a href="#" class="btn btn-secondary" onclick="toggleEditPanel('{{ $user->id }}')">Edytuj</a>
                        <!-- Przycisk usuwania -->
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</button>
                        </form>
                    </td>
                </tr>
                <tr id="edit-panel-{{ $user->id }}" style="display: none;">
                    <!-- Panel edycji -->
                    <td colspan="8">
                        <form action="{{ route('admin.updateUser', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="first_name-{{ $user->id }}">Imie</label>
                                <input type="text" class="form-control" id="first_name-{{ $user->id }}" name="first_name" required value="{{ $user->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name-{{ $user->id }}">Nazwisko</label>
                                <input type="text" class="form-control" id="last_name-{{ $user->id }}" name="last_name" required value="{{ $user->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="email-{{ $user->id }}">Email</label>
                                <input type="email" class="form-control" id="email-{{ $user->id }}" name="email" required value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="address-{{ $user->id }}">Adres</label>
                                <input type="text" class="form-control" id="address-{{ $user->id }}" name="address" required value="{{ $user->address }}">
                            </div>
                            <div class="form-group">
                                <label for="city">Miasto</label>
                                <input type="text" class="form-control" id="city" name="city" required value="{{ $user->city }}">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="admin" name="admin" @if($user->isAdmin()) checked @endif>
                                <label class="form-check-label" for="admin">Administrator</label>
                            </div>
                            <button type="submit" class="btn btn-secondary m-2 w-30">Zapisz</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-4') }} 
            </div>
        </div>
    </div>
    
    
    @include('layouts.footer', ['fixedBottom' => false])
    <script defer src="{{ asset('js/magnification.js') }}"></script> 
    <script>
        function toggleEditPanel(userId) {
            var editPanel = document.getElementById('edit-panel-' + userId);
            if (editPanel.style.display === 'none') {
                editPanel.style.display = 'table-row';
            } else {
                editPanel.style.display = 'none';
            }
        }
    </script>       
</body>
</html>
