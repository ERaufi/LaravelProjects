@extends('layouts.app')
@section('head')
    <title>Form Builder</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ URL('formbuilder') }}" class="btn btn-success">Create</a>
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr>
                            <td>{{ $form->name }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
