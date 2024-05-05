@include('layouts.html')
  
  @include('layouts.head', ['pageTitle' => 'RentalVOD - regulamin'])
  <body>
    @include('layouts.navbar', ['categories' => $categories])

    
    @include('layouts.footer', ['fixedBottom' => false])
</body>
</html>