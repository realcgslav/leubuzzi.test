@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>Journalists wtf</h1>
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
            <tr data-journalist-id="{{ $journalist->id }}">
                <td>{{ $journalist->name }}</td>
                <td>{{ $journalist->phone }}</td>
                <td>{{ $journalist->private_email }}</td>
                <td>{{ $journalist->work_email }}</td>
                <td class="journalist-kz-persons">{{ implode(', ', $journalist->kz_person ?? []) }}</td>
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
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }

        const newOption = document.createElement('option');
        newOption.value = data.id;
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

    </script>
@endsection
