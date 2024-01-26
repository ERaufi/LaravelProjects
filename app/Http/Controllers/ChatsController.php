<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    //
    public function sendMessage(Request $request)
    {
        $item = new Chats();
        $item->date_time = now();
        $item->send_by = Auth::user()->id;
        $item->send_to = 1;
        $item->message = $request->message;
        $item->save();

        return response()->json('Added Successfully');
    }

    public function getNewMessages()
    {
        $message = Chats::where('send_to', Auth()->user()->id)
            ->where('is_received', 0)
            ->with('sender')
            ->first();

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        if ($message) {
            $eventData = [
                'message' => $message->message,
                'sender' => $message->sender->name,
            ];

            echo "data:" . json_encode($eventData) . "\n\n";
            $message->is_received = 1;
            $message->update();
        } else {
            echo "\n\n";
        }

        ob_flush();
        flush();
    }
}
