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


        .users-list {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .user-item:hover {
            background-color: #e6e6e6;
        }

        .user-item p {
            margin-left: 10px;
            font-weight: bold;
        }

        /* Style for round user image in users list */
        .user-item .user_image {
            width: 30px;
            height: 30px;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-item.active {
            background-color: #007bff;
            /* Adjust the color as needed */
            color: #fff;
            /* Adjust the text color as needed */
        }

        #outgoing {
            width: 600px;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-2">
                <div class="users-list">
                    @foreach ($users as $user)
                        <div class="user-item" id="{{ $user->id }}" onclick="selectUser({{ $user->id }})">
                            <a href="#">
                                <div class="user_image" style="background-image: url('{{ URL::asset('assets/img/avatars/1.png') }}')"></div>
                            </a>
                            <p>{{ $user->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <p>Messenger</p>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="card-footer">
                        <input type="text" class="form-control" id="messageInput" placeholder="Enter your message...">
                        <button type="button" onclick="sendMessage()" class="btn btn-success" id="sendButton">Send</button>
                        <input type="file" id="imageUpload" accept="image/*" style="display:none;">
                        <button type="button" onclick="document.getElementById('imageUpload').click();" class="btn btn-info">Upload Image</button>
                        <button type="button" onclick="initiateAudioCall()" class="btn btn-primary">Call</button>
                        {{-- <button type="button" onclick="initiateVideoCall()" class="btn btn-primary">Call Video</button> --}}

                    </div>
                </div>
                {{-- <textarea id="offer" name="offer"></textarea>
                <video id="localVideo" autoplay muted></video>
                <video id="remoteVideo" autoplay></video>
                <button id="startCall">Start Call</button>
                <button id="connectWithOffer">Connect using offer</button> --}}







                <div class="row">
                    <div class="col-5 pt-5 ps-5 col-sm-7">
                        <label class="form-label">Enter Room ID to connect or create</label>
                        <input id="room-input" type="text" class="form-control" placeholder="room ID">
                        <br>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-secondary mb-3" onclick="createRoom()">Create Room</button>
                            <button type="submit" class="btn btn-primary mb-3" onclick="joinRoom()">Join Room</button>
                            <button type="submit" class="btn btn-success mb-3" onclick="joinRoomWithoutCamShareScreen()">Join
                                Room and Share screen directly</button>
                            <button type="submit" class="btn btn-dark mb-3" onclick="joinRoomShareVideoAsStream()">Join
                                Room and stream local media </button>
                        </div>
                    </div>
                    <div class="col-7 pt-5 ps-5 pe-5 col-sm-5">
                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert" id="notification" hidden>
                            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col ps-5 pt-5" id="local-vid-container" hidden>
                        <div class="row">
                            <div class="col">
                                <h2>Local Stream</h2>
                            </div>

                        </div>
                        <div class="row p-3">
                            <video height="300" id="local-video" controls class="local-video"></video>
                        </div>
                        <div class="row">
                            <div class="col-3 col-sm-12"><button type="submit" class="btn btn-success mb-3" onclick="startScreenShare()">Share Screen</button>
                            </div>
                        </div>
                    </div>
                    <div class="col ps-5 pt-5" id="screenshare-container" hidden>
                        <div class="row">
                            <div class="col">
                                <h2>Screen Shared Stream</h2>
                            </div>

                        </div>
                        <div class="row p-3">
                            <video height="300" id="screenshared-video" controls class="local-video"></video>
                        </div>
                        <!-- <div class="row">
                                                                                                                    <div class="col-3 col-sm-12"><button type="submit" class="btn btn-success mb-3"
                                                                                                                            onclick="startScreenShare()">Share Screen</button>
                                                                                                                    </div>
                                                                                                                </div> -->
                    </div>
                    <div class="col ps-5 pt-5" id="remote-vid-container" hidden>
                        <div class="row">
                            <div class="col">
                                <h2>Remote Stream</h2>
                            </div>

                        </div>
                        <div class="row p-3">
                            <video height="300" id="remote-video" controls class="remote-video"></video>
                        </div>
                    </div>

                    <div class="col ps-5 pt-5" id="local-mdeia-container" hidden>
                        <div class="row">

                            <div class="col">
                                <h2>Local video from media</h2>
                                <h6>On play stream to remote peer</h6>
                            </div>
                        </div>
                        <div class="row p-3">
                            <video height="300" id="local-media" controls muted loop src="/media/im.abhishekbhardwaj bharmour.mp4"></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        var userID = null;
        // Trigger send action on Enter key press
        $("#messageInput").on('keypress', function(e) {
            if (e.which === 13) {
                sendMessage(); // Call your send message function
            }
        });

        function sendMessage() {
            $.ajax({
                type: 'post',
                url: '{{ URL('send-message') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'message': $("#messageInput").val(),
                    'user': userID,
                },
                success: function(data) {
                    console.log(data);
                    addMessageToBoard(data);
                }
            });
            $("#messageInput").val('');

        };

        newMessages = new EventSource(`{{ URL('/get-new-messages') }}/0}`);

        function setupEventSource() {
            newMessages.close();
            if (userID) {
                // Close existing EventSource connection if it exists
                if (newMessages) {
                    newMessages.close();
                }

                // Create a new EventSource for the selected user
                newMessages = new EventSource(`{{ URL('/get-new-messages') }}/${userID}`);

                newMessages.onmessage = function(event) {
                    let message = JSON.parse(event.data);
                    addMessageToBoard(message.item);
                };
            }
        }


        function selectUser(userId) {
            $(".user-item").removeClass("active");
            $(`#${userId}`).addClass("active");
            $(".card-body").empty();
            userID = userId;
            getChatHistory();
            setupEventSource();
        }

        function getChatHistory() {
            $(".card-body").empty();

            $.ajax({
                type: 'get',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                url: '{{ URL('communication-history') }}',
                data: {
                    'userID': userID
                },
                success: function(data) {
                    console.log(data);
                    data.forEach(function(message) {
                        addMessageToBoard(message);
                    });
                }
            });
        }


        $('#imageUpload').on('change', function() {
            var file = $(this)[0].files[0];
            var formData = new FormData();
            formData.append('image', file);
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('userID', userID);
            $.ajax({
                url: '{{ URL('upload-communication-photo') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    addMessageToBoard(response)
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });


        function addMessageToBoard(message) {
            if (message.send_by == {{ Auth::user()->id }}) {
                // Append sent messages
                $(".card-body").append(`
                        <div class="send_messages">
                            <div class="user_image" style="background-image: url({{ URL::asset('assets/img/avatars/1.png') }})"></div>
                            <div class="msg-bubble">
                                <div class="msg-text">
                                    ${checkMessageType(message)}
                                </div>
                            </div>
                        </div>
                    `);
            } else {
                // Append received messages
                $(".card-body").append(`
                        <div class="received_messages">
                            <div class="user_image" style="background-image: url({{ URL::asset('assets/img/avatars/1.png') }})"></div>
                            <div class="msg-bubble">
                                <div class="msg-text">
                                    ${checkMessageType(message)}
                                </div>
                            </div>
                        </div>
                    `);
            }
        }

        function checkMessageType(message) {
            if (message.message_type == 'text') {
                return message.message;
            }

            if (message.message_type == 'attachment') {
                return `
                    <img style="width:250px" src="{{ URL::asset('/') }}${message.message}"/>
                `
            }

            if (message.message_type == 'call') {
                if(message.is_received==1)
                {
                return `
                 <img style="width:150px" src="{{ URL::asset('assets/img/phone.svg') }}"/>
                `
                }else{
                    answerCall(message.callOffer);
                }

                // answerCall(callinfo);
            }
        }





























        var callOffer = null;

        function createRandomString(length) {
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let result = "";
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return result;
        }

        function initiateAudioCall() {
            callOffer = createRandomString(20);
            console.log(callOffer);
            $.ajax({
                type: 'post',
                url: '{{ URL('make-call') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'userId': userID,
                    'callOffer': callOffer
                },
                success: function(data) {
                    console.log(data);
                    createRoom();
                }
            });
        }






































































        var room_id;
        var getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        var local_stream;
        var screenStream;
        var peer = null;
        var currentPeer = null
        var screenSharing = false

        function createRoom() {
            console.log("Creating Room")
            // let room = document.getElementById("room-input").value;
            // if (room == " " || room == "") {
            //     alert("Please enter room number")
            //     return;
            // }
            // room_id = room;
            peer = new Peer(callOffer)
            peer.on('open', (id) => {
                console.log("Peer Room ID: ", id)
                getUserMedia({
                    video: true,
                    audio: true
                }, (stream) => {
                    console.log(stream);
                    local_stream = stream;
                    setLocalStream(local_stream)
                }, (err) => {
                    console.log(err)
                })
                notify("Waiting for peer to join.")
            })
            peer.on('call', (call) => {
                call.answer(local_stream);
                call.on('stream', (stream) => {
                    console.log("got call");
                    console.log(stream);
                    setRemoteStream(stream)
                })
                currentPeer = call;
            })
        }

        function setLocalStream(stream) {
            document.getElementById("local-vid-container").hidden = false;
            let video = document.getElementById("local-video");
            video.srcObject = stream;
            video.muted = true;
            video.play();
        }

        function setScreenSharingStream(stream) {
            document.getElementById("screenshare-container").hidden = false;
            let video = document.getElementById("screenshared-video");
            video.srcObject = stream;
            video.muted = true;
            video.play();
        }

        function setRemoteStream(stream) {
            document.getElementById("remote-vid-container").hidden = false;
            let video = document.getElementById("remote-video");
            video.srcObject = stream;
            video.play();
        }


        function notify(msg) {
            let notification = document.getElementById("notification")
            notification.innerHTML = msg
            notification.hidden = false
            setTimeout(() => {
                notification.hidden = true;
            }, 3000)
        }

        function answerCall(callOffer) {
            // console.log("Joining Room")
            // let room = document.getElementById("room-input").value;
            // if (room == " " || room == "") {
            //     alert("Please enter room number")
            //     return;
            // }
            // room_id = room;
            peer = new Peer()
            peer.on('open', (id) => {
                console.log("Connected room with Id: " + id)

                getUserMedia({
                    video: true,
                    audio: true
                }, (stream) => {
                    local_stream = stream;
                    setLocalStream(local_stream)
                    notify("Joining peer")
                    let call = peer.call(callOffer, stream)
                    call.on('stream', (stream) => {
                        setRemoteStream(stream);

                    })
                    currentPeer = call;
                }, (err) => {
                    console.log(err)
                })

            })
        }

        function joinRoomWithoutCamShareScreen() {
            // join a call and drirectly share screen, without accesing camera
            console.log("Joining Room")
            let room = document.getElementById("room-input").value;
            if (room == " " || room == "") {
                alert("Please enter room number")
                return;
            }
            room_id = room;
            peer = new Peer()
            peer.on('open', (id) => {
                console.log("Connected with Id: " + id)

                const createMediaStreamFake = () => {
                    return new MediaStream([createEmptyAudioTrack(), createEmptyVideoTrack({
                        width: 640,
                        height: 480
                    })]);
                }

                const createEmptyAudioTrack = () => {
                    const ctx = new AudioContext();
                    const oscillator = ctx.createOscillator();
                    const dst = oscillator.connect(ctx.createMediaStreamDestination());
                    oscillator.start();
                    const track = dst.stream.getAudioTracks()[0];
                    return Object.assign(track, {
                        enabled: false
                    });
                }

                const createEmptyVideoTrack = ({
                    width,
                    height
                }) => {
                    const canvas = Object.assign(document.createElement('canvas'), {
                        width,
                        height
                    });
                    const ctx = canvas.getContext('2d');
                    ctx.fillStyle = "green";
                    ctx.fillRect(0, 0, width, height);

                    const stream = canvas.captureStream();
                    const track = stream.getVideoTracks()[0];

                    return Object.assign(track, {
                        enabled: false
                    });
                };

                notify("Joining peer")
                let call = peer.call(room_id, createMediaStreamFake())
                call.on('stream', (stream) => {
                    setRemoteStream(stream);

                })

                currentPeer = call;
                startScreenShare();

            })
        }

        function joinRoomShareVideoAsStream() {
            // Play video from local media
            console.log("Joining Room")
            let room = document.getElementById("room-input").value;
            if (room == " " || room == "") {
                alert("Please enter room number")
                return;
            }

            room_id = room;
            peer = new Peer()
            peer.on('open', (id) => {
                console.log("Connected with Id: " + id)

                document.getElementById("local-mdeia-container").hidden = false;

                const video = document.getElementById('local-media');
                video.onplay = function() {
                    const stream = video.captureStream();
                    notify("Joining peer")
                    let call = peer.call(room_id, stream)

                    // Show remote stream on my side
                    call.on('stream', (stream) => {
                        setRemoteStream(stream);

                    })
                };
                video.play();
            })
        }

        function startScreenShare() {
            if (screenSharing) {
                stopScreenSharing()
            }
            navigator.mediaDevices.getDisplayMedia({
                video: true
            }).then((stream) => {
                setScreenSharingStream(stream);

                screenStream = stream;
                let videoTrack = screenStream.getVideoTracks()[0];
                videoTrack.onended = () => {
                    stopScreenSharing()
                }
                if (peer) {
                    let sender = currentPeer.peerConnection.getSenders().find(function(s) {
                        return s.track.kind == videoTrack.kind;
                    })
                    sender.replaceTrack(videoTrack)
                    screenSharing = true
                }
                console.log(screenStream)
            })
        }

        function stopScreenSharing() {
            if (!screenSharing) return;
            let videoTrack = local_stream.getVideoTracks()[0];
            if (peer) {
                let sender = currentPeer.peerConnection.getSenders().find(function(s) {
                    return s.track.kind == videoTrack.kind;
                })
                sender.replaceTrack(videoTrack)
            }
            screenStream.getTracks().forEach(function(track) {
                track.stop();
            });
            screenSharing = false
        }
    </script>
@endsection
