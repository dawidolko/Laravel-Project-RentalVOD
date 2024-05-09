@include('layouts.html')
  
  @include('layouts.head', ['pageTitle' => 'RentalVOD - regulamin'])
  <head>
    <style>
        ul>li {
            font-weight: lighter;
            color: rgba(255, 255, 255, 0.603);
        }
    </style>
  </head>
  <body>
    @include('layouts.navbar')

    <h1 class="text-white container mt-5">Regulamin</h1>
    <ol class="text-danger2 fw-bold container mt-5">
        <li class=>Rejestracja
            <ul>
                <li>Każdy użytkownik pragnący korzystać z usług RentalVOD musi zarejestrować się, podając swoje rzeczywiste dane osobowe, w tym imię, nazwisko, adres zamieszkania oraz adres e-mail.</li>
                <li>Użytkownik zobowiązany jest do aktualizacji swoich danych osobowych w serwisie w przypadku ich zmiany.</li>
            </ul>
        </li>

        <li>Wybór filmów
            <ul>
                <li>Użytkownicy mają dostęp do szerokiej oferty filmów dostępnych w RentalVOD.</li>
                <li>Ceny wypożyczenia są wyraźnie oznaczone przy każdym filmie.</li>
                <li>Filmy mogą być dodawane do koszyka w celu późniejszego wypożyczenia.</li>
            </ul>
        </li>

        <li>Zamówienie i wypożyczenie
            <ul>
                <li>Wypożyczenie filmu jest możliwe przez skompletowanie zamówienia i dokonanie płatności online.</li>
                <li>Po złożeniu zamówienia użytkownik otrzymuje potwierdzenie wraz z szczegółami dotyczącymi płatności i terminu wypożyczenia.</li>
                <li>Maksymalny czas wypożyczenia jednego filmu wynosi 14 dni.</li>
            </ul>
        </li>

        <li>Opłaty i płatności
            <ul>
                <li>Opłata za wypożyczenie jest naliczana według ceny określonej przy każdym filmie.</li>
                <li>Użytkownik zobowiązany jest do zapłaty za wypożyczenie przed jego rozpoczęciem.</li>
                <li>Za przetrzymanie filmów po wyznaczonym terminie naliczane są dodatkowe opłaty.</li>
            </ul>
        </li>

        <li>Dostawa i zwrot
            <ul>
                <li>Filmy są dostarczane cyfrowo, bezpośrednio na platformę użytkownika po dokonaniu płatności.</li>
                <li>Użytkownik zobowiązany jest do "zwrotu" filmu poprzez usunięcie go ze swojej biblioteki cyfrowej po upływie okresu wypożyczenia.</li>
            </ul>
        </li>

        <li>Kary za opóźnienie
            <ul>
                <li>Za każdy dzień opóźnienia w usunięciu filmu z konta użytkownika naliczane są kary w wysokości 600% stawki dziennej.</li>
            </ul>
        </li>

        <li>Odpowiedzialność za utratę lub uszkodzenie treści cyfrowych
            <ul>
                <li>Użytkownik jest odpowiedzialny za utratę dostępu lub uszkodzenie plików filmowych wynikające z jego działań.</li>
                <li>W przypadku utraty lub uszkodzenia treści, użytkownik może być obciążony kosztami związanymi z przywróceniem dostępu do filmu.</li>
            </ul>
        </li>

        <li>Zakończenie umowy
            <ul>
                <li>Użytkownik może zakończyć umowę z RentalVOD w dowolnym momencie, z zastrzeżeniem uregulowania wszelkich zobowiązań finansowych.</li>
            </ul>
        </li>

        <li>Zmiany w regulaminie
            <ul>
                <li>RentalVOD zastrzega sobie prawo do wprowadzania zmian w regulaminie. Użytkownicy zostaną poinformowani o wszelkich zmianach przez aktualizacje na stronie internetowej.</li>
            </ul>
        </li>

        <li>Postanowienia końcowe
            <ul>
                <li>W przypadku sporów decydujące jest prawo obowiązujące w jurysdykcji siedziby firmy.</li>
                <li>RentalVOD nie ponosi odpowiedzialności za szkody wynikłe z użytkowania serwisu poza zakresem gwarancji usługodawcy.</li>
            </ul>
        </li>
    </ol>
    <br>
    <br>
    <br>
    <br>

    @include('layouts.footer', ['fixedBottom' => false])
</body>
</html>
