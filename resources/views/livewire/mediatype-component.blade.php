@extends('components.layouts.app')
@section('content')
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="btn btn-primary">Add Media Type</button>

    @if($isOpen)
        @include('livewire.create-mediatype')
    @endif

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No.</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mediaTypes as $mediaType)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $mediaType->type }}</td>
                <td>
                    <button wire:click="edit({{ $mediaType->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="delete({{ $mediaType->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection