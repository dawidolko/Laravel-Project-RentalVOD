
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
        display: flex;
        justify-content: space-between;
        align-items: center;
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

        .list-group-item .actions {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
</head>
<body>
  @include('layouts.navbar')


{{-- 
<div class="container text-white">
    <h1>Wszystkie zamówienia</h1>

    <ul class="list-group text-white">
        @foreach ($loans as $loan)
            <li class="list-group-item bg-dark text-white">
                <div>
                    <strong>ID zamówienia:</strong> {{ $loan->id }}
                    <strong>Data zamówienia:</strong> {{ $loan->start_loan }}
                    <strong>Email klienta:</strong> {{ $loan->user->email }}<br>
                    <strong>Filmy:</strong>
                    <ul>
                        @foreach ($loan->movies as $movie)
                            <li>{{ $movie->title }}</li>
                        @endforeach
                    </ul>
                    <strong>Status:</strong> {{ $loan->status }}
                </div>
                <div class="actions">
                    <button class="btn custom-btn m-2 w-100" onclick="showForm({{ $loan->id }})">Zmień status</button>
                    <form id="form-{{ $loan->id }}" class="m-2" style="display: none;" action="{{ route('loans.update', $loan->id) }}" method="post">
                        @csrf
                        @method('put')
                        <select name="status" class="form-control">
                            <option value="Nieopłacone" {{ $loan->status == 'Nieopłacone' ? 'selected' : '' }}>Nieopłacone</option>
                            <option value="Opłacone" {{ $loan->status == 'Opłacone' ? 'selected' : '' }}>Opłacone</option>
                            <option value="Wysłane" {{ $loan->status == 'Wysłane' ? 'selected' : '' }}>Wysłane</option>
                            <option value="Zwrócone" {{ $loan->status == 'Zwrócone' ? 'selected' : '' }}>Zwrócone</option>
                        </select>
                        <button type="submit" class="btn btn-danger mt-2">Zapisz</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function showForm(id) {
        var form = document.getElementById('form-' + id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script> --}}

@include('layouts.footer', ['fixedBottom' => false])
<script defer src="{{ asset('js/magnification.js') }}"></script>
</body>
</html>
