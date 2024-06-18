@extends('layouts.app')

@section('content')
    <h1>Edit Journalist</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('journalists.update', $journalist->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" required value="{{ old('name', $journalist->name) }}">
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $journalist->phone) }}">
        </div>
        <div>
            <label>Private Email</label>
            <input type="email" name="private_email" value="{{ old('private_email', $journalist->private_email) }}">
        </div>
        <div>
            <label>Work Email</label>
            <input type="email" name="work_email" value="{{ old('work_email', $journalist->work_email) }}">
        </div>
        <div>
            <label>KZ Person</label>
            <select name="kz_person[]" multiple>
                @foreach($kzPeople as $kzPerson)
                    <option value="{{ $kzPerson->person }}" {{ in_array($kzPerson->person, $journalist->kz_person ?? []) ? 'selected' : '' }}>{{ $kzPerson->person }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Media</label>
            <select name="media[]" multiple>
                @foreach($media as $medium)
                    <option value="{{ $medium->id }}" {{ in_array($medium->id, $journalist->media->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $medium->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Additional Info</label>
            <textarea name="additional_info">{{ old('additional_info', $journalist->additional_info) }}</textarea>
        </div>

        <h3>Manage KZ Persons</h3>
        <div id="kz-persons">
            <input type="text" name="new_kz_persons[]" placeholder="New KZ Person">
        </div>
        <button type="button" id="add-kz-person">Add KZ Person</button>

        <button type="submit">Save</button>
    </form>

    <script>
        document.getElementById('add-kz-person').addEventListener('click', function() {
            var div = document.createElement('div');
            div.innerHTML = '<input type="text" name="new_kz_persons[]" placeholder="New KZ Person">';
            document.getElementById('kz-persons').appendChild(div);
        });
    </script>
@endsection
