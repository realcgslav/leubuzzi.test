@extends('layouts.app')

@section('content')
    <h1>Add Journalist</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('journalists.store') }}">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div>
            <label>Private Email</label>
            <input type="email" name="private_email" value="{{ old('private_email') }}">
        </div>
        <div>
            <label>Work Email</label>
            <input type="email" name="work_email" value="{{ old('work_email') }}">
        </div>
        <div>
            <label>KZ Person</label>
            <select name="kz_person[]" multiple>
                @foreach($kzPeople as $kzPerson)
                    <option value="{{ $kzPerson->person }}">{{ $kzPerson->person }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Media</label>
            <select name="media[]" multiple>
                @foreach($media as $medium)
                    <option value="{{ $medium->id }}">{{ $medium->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Additional Info</label>
            <textarea name="additional_info">{{ old('additional_info') }}</textarea>
        </div>
        <button type="submit">Save</button>
    </form>
@endsection