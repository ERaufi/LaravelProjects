@extends('layouts.app')

@section('head')
    <style>
        .table {
            width: 50%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style for checkboxes */
        .styled-checkbox {
            position: relative;
            cursor: pointer;
            display: inline-block;
        }

        .styled-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border: 1px solid #ccc;
        }

        .styled-checkbox input:checked+.checkmark:after {
            content: "";
            position: absolute;
            display: block;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid #333;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ __('Create New Role') }}</h1>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ URL('update-role') }}">
                @csrf
                <input type="text" id="id" name="id" value="{{ $role->id }}" readonly required hidden />
                <label for="name">{{ __('Role Name') }}</label>
                <input type="text" required name="name" class="form-control" value="{{ $role->name }}" />


                <div class="row">
                    <div class="col-md-6">
                        <h1>{{ __('Permissions') }}</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Permission') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td class="styled-checkbox">
                                            <input type="checkbox" value="{{ $permission->name }}" name="permission[]" id="permission_{{ $permission->id }}"
                                                @if ($role->permissions->contains('id', $permission->id)) checked @endif />
                                            <label class="checkmark" for="permission_{{ $permission->id }}"></label>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-6">
                        <h1>{{ __('Users') }}</h1>

                        <label for="users">{{ __('Users') }}</label>
                        <select class="form-control" name="users[]" id="users" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($role->users->contains('id', $user->id)) selected @endif>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="submit" class="btn btn-success" value="{{ __('Save') }}" />
            </form>
        </div>
    </div>
@endsection
