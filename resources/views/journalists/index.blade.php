@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Journalists</h1>
    <a href="{{ route('journalists.create') }}">Add Journalist</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Private Email</th>
            <th>Work Email</th>
            <th>KZ Person</th>
            <th>Media</th>
            <th>Additional Info</th>
            <th>Actions</th>
        </tr>
        @foreach($journalists as $journalist)
            <tr>
                <td>{{ $journalist->name }}</td>
                <td>{{ $journalist->phone }}</td>
                <td>{{ $journalist->private_email }}</td>
                <td>{{ $journalist->work_email }}</td>
                <td>{{ implode(', ', $journalist->kz_person ?? []) }}</td>
                <td>{{ $journalist->media->pluck('name')->implode(', ') }}</td>
                <td>{{ $journalist->additional_info }}</td>
                <td>
                    <a href="{{ route('journalists.edit', $journalist->id) }}">Edit</a>
                    <form action="{{ route('journalists.destroy', $journalist->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this journalist?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <h2>Manage KZ Persons</h2>
    <form method="POST" action="{{ route('journalists.addPerson') }}">
        @csrf
        <input type="text" name="person" required>
        <button type="submit">Add Person</button>
    </form>
   
        @foreach($kzPeople as $kzPerson)
            <div class="person-tag">
                <form action="{{ route('journalists.editPerson', $kzPerson->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <input type="text" name="person" value="{{ $kzPerson->person }}" required>
                    <button type="submit">Edit</button>
                </form>
                <form action="{{ route('journalists.deletePerson', $kzPerson->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this person?')">Delete</button>
                </form>
            </div>
        @endforeach
 
@endsection
