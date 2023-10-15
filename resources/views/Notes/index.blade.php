@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notes</h1>
    <a href="/notes/create" class="btn btn-primary">Create Note</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notes as $note)
            <tr>
                <td>{{ $note->title }}</td>
                <td>
                    <a href="/notes/{{ $note->id }}" class="btn btn-info">View</a>
                    <a href="/notes/{{ $note->id }}/edit" class="btn btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
