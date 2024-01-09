@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{__('Edit Note')}}</h1>
        <form method="POST" action="/notes/{{ $note->id }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">{{__('Title')}}</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $note->title }}">
            </div>
            <div class="form-group">
                <label for="content">{{__('Content')}}</label>
                <textarea class="form-control" id="content" name="content">{{ $note->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
        </form>
    </div>
@endsection
