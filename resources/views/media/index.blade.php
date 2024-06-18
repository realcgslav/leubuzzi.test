@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Media</h1>
    <a href="{{ route('media.create') }}">Add Media</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
        </tr>
        @foreach($media as $medium)
            <tr>
                <td>{{ $medium->name }}</td>
                <td>{{ implode(', ', $medium->type ?? []) }}</td>
            </tr>
        @endforeach
    </table>
@endsection
