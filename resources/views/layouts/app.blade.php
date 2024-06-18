<!DOCTYPE html>
<html>
<head>
    <title>Laravel Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="{{ route('journalists.index') }}">Journalists</a></li>
                <li><a href="{{ route('media.index') }}">Media</a></li>
            </ul>
        </nav>
        @yield('content')
    </div>
</body>
</html>
