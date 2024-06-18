<!DOCTYPE html>
<html>
<head>
    <title>Laravel Journalists App</title>
    @livewireStyles
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="{{ route('journalists') }}">Journalists</a></li>
                <li><a href="{{ route('kzpersons') }}">KZ Persons</a></li>
                <li><a href="{{ route('media') }}">Media</a></li>
                <li><a href="{{ route('mediatypes') }}">Media Types</a></li>
            </ul>
        </nav>
        @yield('content')
    </div>
    @livewireScripts
</body>
</html>
