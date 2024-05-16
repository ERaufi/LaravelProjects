<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SSEController extends Controller
{
    //
    public function sendSSE()
    {
        if (Auth::check()) {
            $notifications = Notifications::where('user_id', Auth()->user()->id)
                ->where('is_send', 0)
                ->first();

            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');

            if ($notifications) {
                $eventData = [
                    'message' => $notifications->message,
                ];

                echo "data:" . json_encode($eventData) . "\n\n";
                $notifications->is_send = 1;
                $notifications->update();
            } else {
                echo "\n\n";
            }

            ob_flush();
            flush();
        }
    }





    public function sseForDashboard()
    {
        // Set headers for SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // Flush the output buffer to send the headers
        ob_flush();
        flush();

        // Keep the connection open
        while (true) {
            echo "\n\n"; // Send a ping event to keep the connection alive
            ob_flush();
            flush();

            // Wait for a short period before sending the next ping event
            usleep(1000000); // Sleep for 1 second (1000000 microseconds = 1 second)
        }
    }
}
