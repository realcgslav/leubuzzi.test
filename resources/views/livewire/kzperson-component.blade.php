@extends('components.layouts.app')

@section('content')
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="btn btn-primary">Add KZ Person</button>

    @if($isOpen)
        @include('livewire.create-kzperson')
    @endif

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kzPersons as $kzPerson)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $kzPerson->name }}</td>
                <td>
                    <button wire:click="edit({{ $kzPerson->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="delete({{ $kzPerson->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
