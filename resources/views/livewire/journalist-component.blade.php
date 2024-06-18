@extends('components.layouts.app')

@section('content')
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="btn btn-primary">Add Journalist</button>

    @if($isOpen)
        @include('livewire.create')
    @endif

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Private Email</th>
                <th>Work Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journalists as $journalist)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $journalist->name }}</td>
                <td>{{ $journalist->phone }}</td>
                <td>{{ $journalist->private_email }}</td>
                <td>{{ $journalist->work_email }}</td>
                <td>
                    <button wire:click="edit({{ $journalist->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="delete({{ $journalist->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
