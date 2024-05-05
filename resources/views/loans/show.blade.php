@include('layouts.html')
@include('layouts.head', ['pageTitle' => 'RentalVOD - film: ' . $movie->title])
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    h2{
        margin-top: 20px;
    }
</style>

<body>
@include('layouts.navbar')

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1>{{ $movie->title }}</h1>
            <!-- Embed YouTube video -->
            <div class="video-container">
                @if ($movie->video_path)
                    <iframe src="https://www.youtube.com/embed/{{ $movie->video_path }}?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <p>Video is not available.</p>
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
