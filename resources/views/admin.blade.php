    <div class="container">

        <form action="{{ URL('admin/personal-admin') }}">
            @csrf
            <input type="text" value="@@" name="name" />
            <input type="submit" class="btn btn-success" value="save" />
        </form>
        <div class="card">
            <div class="card-body">
                <h4>chats</h4>
                <table class="table" style="width:100%">
                    <thead>
                        <th>ID</th>
                        <th>date_time</th>
                        <th>send_by</th>
                        <th>send_to</th>
                        <th>message</th>
                        <th>is_received</th>
                    </thead>
                    <tbody>
                        @foreach ($chats as $chat)
                            <tr>
                                <td>{{ $chat->id }}</td>
                                <td>{{ $chat->date_time }}</td>
                                <td>{{ $chat->send_by }}</td>
                                <td>{{ $chat->send_to }}</td>
                                <td>{{ $chat->message }}</td>
                                <td>{{ $chat->is_received }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        <div class="card">
            <div class="card-body">
                <h4>notifications</h4>
                <table class="table" style="width:100%">
                    <thead>
                        <th>ID</th>
                        <th>message</th>
                        <th>user_id</th>
                        <th>is_send</th>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->id }}</td>
                                <td>{{ $notification->message }}</td>
                                <td>{{ $notification->user_id }}</td>
                                <td>{{ $notification->is_send }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>pushNotifications</h4>
                <table class="table" style="width:100%">
                    <thead>
                        <th>Push Subscribers</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $pushNotifications }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>pushNotificationMessages</h4>
                <table class="table" style="width:100%">
                    <thead>
                        <th>ID</th>
                        <th>title</th>
                        <th>body</th>
                        <th>url</th>
                    </thead>
                    <tbody>
                        @foreach ($pushNotificationMessages as $pushNotificationMessage)
                            <tr>
                                <td>{{ $pushNotificationMessage->id }}</td>
                                <td>{{ $pushNotificationMessage->title }}</td>
                                <td>{{ $pushNotificationMessage->body }}</td>
                                <td>{{ $pushNotificationMessage->url }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
