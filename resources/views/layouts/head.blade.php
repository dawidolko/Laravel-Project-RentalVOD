<head>
    <link rel="icon" href="storage/img/logo.webp">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/theme.js') }}"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .rotate-icon {
            transition: transform 0.3s ease;
        }

        .rotate-icon.open {
            transform: rotate(180deg);
        }
        .red-after:hover {
        color: rgba(var(--bs-danger-rgb), var(--bs-bg-opacity)) !important;
        }
    </style>
</head>
