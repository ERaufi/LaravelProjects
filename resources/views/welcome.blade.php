@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <h1>{{ __('Wellcome') }} {{ Auth::user()->name }}</h1>
        </div>
    </div>
@endsection
