@extends('layouts.app')

@section('content')
    <h1>Journalists</h1>
    <a href="{{ route('journalists.create') }}">Add Journalist</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Private Email</th>
            <th>Work Email</th>
            <!-- Other columns -->
        </tr>
        @foreach($journalists as $journalist)
            <tr>
                <td>{{ $journalist->name }}</td>
                <td>{{ $journalist->phone }}</td>
                <td>{{ $journalist->private_email }}</td>
                <td>{{ $journalist->work_email }}</td>
                <!-- Other columns -->
            </tr>
        @endforeach
    </table>
@endsection