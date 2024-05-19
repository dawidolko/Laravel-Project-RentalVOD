@include('layouts.html')
@include('layouts.slider')
@include('layouts.head', ['pageTitle' => 'RentalVOD - admin users'])

<head>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <link rel="stylesheet" href="{{ asset('css/moviesStyle.css') }}">
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
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
    <div class="container w-100">
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

        <h1>Wszyscy klienci</h1>
        <div class="table-responsive"> 
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
                        <td>{{ $user->id }}</td>
                        <td><img src="{{ asset($user->avatar) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;"></td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ str_repeat('*', 5) }}</td>
                        <td style="display: flex;">
                            <a href="#" class="btn btn-secondary" onclick="toggleEditPanel('{{ $user->id }}')">Edytuj</a>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <tr id="edit-panel-{{ $user->id }}" style="display: none;">
                        <td colspan="8">
                            <form action="{{ route('admin.updateUser', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="first_name-{{ $user->id }}">Imię</label>
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
        </div>
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
