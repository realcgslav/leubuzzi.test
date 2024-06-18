@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Media</h1>
    <a href="{{ route('media.create') }}">Add Media</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        @foreach($media as $medium)
            <tr>
                <td>{{ $medium->name }}</td>
                <td>{{ implode(', ', $medium->type ?? []) }}</td>
                <td>
                    <a href="{{ route('media.edit', $medium->id) }}">Edit</a>
                    <form action="{{ route('media.destroy', $medium->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this media?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <h2>Manage Media Types</h2>
    <form method="POST" action="{{ route('media.addType') }}">
        @csrf
        <input type="text" name="type" required>
        <button type="submit">Add Type</button>
    </form>
    <ul>
        @foreach($mediaTypes as $mediaType)
            <li>
                {{ $mediaType->type }}
                <form action="{{ route('media.editType', $mediaType->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <input type="text" name="type" value="{{ $mediaType->type }}" required>
                    <button type="submit">Edit</button>
                </form>
                <form action="{{ route('media.deleteType', $mediaType->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this type?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
