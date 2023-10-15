@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Note Details</h1>
        <p><strong>Title:</strong> {{ $note->title }}</p>
        <p><strong>Content:</strong> {{ $note->content }}</p>
        <a href="{{ url('notes') }}" class="btn btn-primary">Back to Notes</a>
    </div>
@endsection
