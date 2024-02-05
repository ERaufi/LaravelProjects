@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Server-Sent Events Demo</h1>
        <div class="row">
            <div class="col-md-4">
                <select id="users_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <input type="text" id="message" class="form-control" />
            </div>

            <div class="col-md-2">
                <input type="button" class="btn btn-success" value="Send" onclick="sendNotification()" />
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function sendNotification(id) {
            $.ajax({
                type: 'post',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('create-notification') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $("#users_id").val(),
                    'message': $("#message").val(),
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
