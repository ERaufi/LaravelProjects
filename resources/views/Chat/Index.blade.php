@extends('layouts.app')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Style for round user image */
        .user_image {
            width: 40px;
            height: 40px;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
        }

        /* Style for sender messages */
        .send_messages {
            /* display: flex;
                justify-content: flex-end;
                margin-bottom: 15px; */
            display: flex;
            justify-content: flex-start;
            margin-bottom: 15px;
            flex-direction: row-reverse;
        }

        .send_messages .msg-bubble {
            background-color: #d3d3d3;
            /* Gray background color for sender messages */
            border-radius: 10px;
            max-width: 70%;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        /* Move the user image to the right */
        .send_messages .user_image {
            margin-left: 10px;
        }

        /* Style for receiver messages */
        .received_messages {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 15px;
        }

        .received_messages .msg-bubble {
            background-color: #3498db;
            /* Blue background color for receiver messages */
            border-radius: 10px;
            max-width: 70%;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        /* Move the user image to the left */
        .received_messages .user_image {
            margin-right: 10px;
        }

        /* Style for card-body to make it scrollable and take 100% height */
        .card-body {
            overflow-y: auto;
            max-height: calc(100vh - 150px);
            /* Adjusted based on your card-footer height */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="users-list">

                </div>
            </div>


            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <p>Messanger</p>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-footer">
                        <input type="text" class="form-control" id="messageInput" placeholder="Enter your message...">
                        <button type="submit" class="btn btn-success" id="sendButton">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#sendButton").on('click', function() {
            $(".card-body").append(`
            <div class="send_messages">
                <div class="user_image" style="background-image: url({{ URL::asset('assets/img/avatars/1.png') }})"></div>

                <div class="msg-bubble">
                    <div class="msg-info">
                        <div class="msg-info-name">Sajad</div>
                        <div class="msg-info-time">${ Date(Date.now())}</div>
                    </div>

                    <div class="msg-text">
                        ${$("#messageInput").val()}
                    </div>
                </div>
            </div>
        `);

            $.ajax({
                type: 'post',
                url: '{{ URL('send-message') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'message': $("#messageInput").val(),
                },
                success: function(data) {
                    console.log(data);
                }
            });
            $("#messageInput").val('');

        });


        var newMessages = new EventSource("{{ URL('/get-new-messages') }}");

        newMessages.onmessage = function(event) {
            let message = JSON.parse(event.data);

            $(".card-body").append(`
                <div class="received_messages">
                    <div class="user_image" style="background-image: url({{ URL::asset('assets/img/avatars/1.png') }})"></div>
                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">${message.sender}</div>
                            <div class="msg-info-time">12:45</div>
                        </div>
                        <div class="msg-text">
                            ${message.message}
                        </div>
                    </div>
                </div>
            `)
        }
    </script>
@endsection
