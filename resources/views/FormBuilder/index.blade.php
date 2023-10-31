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
                            <td>
                                <a href="{{ URL('edit-form-builder', $form->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ URL('read-form-builder', $form->id) }}" class="btn btn-primary">Show</a>
                                <form method="POST" action="{{ URL('form-delete', $form->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
