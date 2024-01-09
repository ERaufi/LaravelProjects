@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{__('Create a Note')}}</h1>
    <form method="POST" action="/notes/store">
        @csrf
        <div class="form-group">
            <label for="title">{{__('Title')}}</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="content">{{__('Content')}}</label>
            <textarea class="form-control" id="content" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
    </form>
</div>
@endsection
