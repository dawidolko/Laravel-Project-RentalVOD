@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - jakość premium film: ' . $movie->title])
<style>
    html, body {
        height: 100%; 
        margin: 0;
        padding: 0;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #f8f9fa; 
        text-align: center;
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; 
        height: 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    h2 {
        margin-top: 20px;
    }
    .marginbig {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-bottom: 60px;
    }
</style>

<body>
@include('layouts.navbar')

<div class="container mt-5 marginbig">
    <div class="card">
        <div class="card-body">
            <h1>{{ $movie->title }}</h1>
            <h2>JAKOŚĆ PREMIUM</h2>
            <div class="video-container">
                @if ($movie->video_path)
                    <iframe src="https://www.youtube.com/embed/{{ $movie->video_path }}?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <p>Film niedostępne.</p>
                @endif
            </div>
            <h2>Opis:</h2>
            <p>{{ $movie->description }}</p>
        </div>
    </div>
</div>

@include('layouts.footer')
</body>
</html>
