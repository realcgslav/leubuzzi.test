@extends('layouts.app')

@section('content')
    <h1>Edit Media</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('media.update', $media->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" required value="{{ old('name', $media->name) }}">
        </div>
        <div>
            <label>Type</label>
            <select name="type[]" multiple>
                @foreach($mediaTypes as $mediaType)
                    <option value="{{ $mediaType->type }}" {{ in_array($mediaType->type, $media->type ?? []) ? 'selected' : '' }}>{{ $mediaType->type }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
