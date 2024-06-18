@extends('layouts.app')

@section('content')
    <h1>Add Media</h1>
    <form method="POST" action="{{ route('media.store') }}">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Type</label>
            <select name="type[]" multiple>
                <option value="Newspaper">Newspaper</option>
                <option value="Magazine">Magazine</option>
                <option value="Online">Online</option>
                <option value="Radio">Radio</option>
                <option value="Television">Television</option>
            </select>
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
