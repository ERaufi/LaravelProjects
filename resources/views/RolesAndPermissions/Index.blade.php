@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ 'Roles And Permissions' }}</h1>
        </div>
        <div class="card-body">
            <a href="{{ URL('create-roles') }}" class="btn btn-success">{{ __('Create Roles') }}</a>

            <table class="table" width="100%">
                <tr>
                    <td>{{ __('Name') }}</td>
                    <td>{{ __('Actions') }}</td>
                </tr>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <input type="button" value="{{ __('Edit') }}" class="btn btn-success" />
                            <input type="button" value="{{ __('Delete') }}" class="btn btn-danger" />
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
