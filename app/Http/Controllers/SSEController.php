<?php

namespace App\Http\Controllers;

use App\Events\addedDataEvent;
use App\Models\Countries;
use App\Models\Covid;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SSEController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->get();

        return view('sse', compact('users'));
    }
    public function sendSSE()
    {

        $notifications = Notifications::where('user_id', Auth()->user()->id)
            ->where('is_send', 0)
            ->first();


        // Set the appropriate headers for Server-Sent Events
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        // Broadcast the event as JSON
        if ($notifications) {
            $eventData = [
                'message' => $notifications->message,
            ];

            // Send the event data
            echo "data: " . json_encode($eventData) . "\n\n";
            $notifications->is_send = 1;
            $notifications->update();
        } else {
            echo "\n\n";
        }

        ob_flush();
        flush();
    }
}
