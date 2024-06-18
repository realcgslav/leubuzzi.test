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
    <form id="edit-journalist-form" method="POST" action="{{ route('journalists.update', $journalist->id) }}">
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
            <select id="kz-person-select" name="kz_person[]" multiple>
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
        <button type="submit">Save</button>
    </form>

    <h2>Manage KZ Persons</h2>
    <form id="add-kz-person-form" method="POST" action="{{ route('journalists.addPerson') }}">
        @csrf
        <input type="text" name="person" required>
        <button type="submit">Add Person</button>
    </form>

    <div id="kz-persons-list">
        @foreach($kzPeople as $kzPerson)
            <div class="person-tag" data-id="{{ $kzPerson->id }}">
                <form class="edit-person-form" action="{{ route('journalists.editPerson', $kzPerson->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <input type="text" name="person" value="{{ $kzPerson->person }}" required>
                    <button type="submit">Edit</button>
                </form>
                <form class="delete-person-form" action="{{ route('journalists.deletePerson', $kzPerson->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this person?')">Delete</button>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        document.getElementById('add-kz-person-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': form.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                const newOption = document.createElement('option');
                newOption.value = data.person;
                newOption.textContent = data.person;
                document.getElementById('kz-person-select').appendChild(newOption);

                const newKzPersonDiv = document.createElement('div');
                newKzPersonDiv.classList.add('person-tag');
                newKzPersonDiv.dataset.id = data.id;
                newKzPersonDiv.innerHTML = `
                    <form class="edit-person-form" action="/journalists/edit-person/${data.id}" method="POST" style="display:inline-block;">
                        @csrf
                        <input type="text" name="person" value="${data.person}" required>
                        <button type="submit">Edit</button>
                    </form>
                    <form class="delete-person-form" action="/journalists/delete-person/${data.id}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this person?')">Delete</button>
                    </form>
                `;
                document.getElementById('kz-persons-list').appendChild(newKzPersonDiv);
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('kz-persons-list').addEventListener('submit', function(event) {
            if (event.target.classList.contains('delete-person-form')) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const personDiv = form.closest('.person-tag');
                        document.getElementById('kz-person-select').querySelector(`option[value="${personDiv.dataset.id}"]`).remove();
                        personDiv.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
