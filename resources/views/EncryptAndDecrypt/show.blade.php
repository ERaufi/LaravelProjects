@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{__('Note Details')}}</h1>
        <p><strong>{{__('Title:')}}</strong> {{ $note->title }}</p>
        <p><strong>{{__('Content:')}}</strong> {{ $note->content }}</p>
        <a href="{{ url('notes') }}" class="btn btn-primary">{{__('Back to Notes')}}</a>
    </div>
@endsection
