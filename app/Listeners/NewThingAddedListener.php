<?php

namespace App\Listeners;

use App\Events\NewThingAddedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewThingAddedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewThingAddedEvent $event)
    {
        // $newUserData = $event->user->toArray();
        $eventData = [
            'message' => 'got it',
        ];
        // Send SSE event
        // echo "event: newUser\n";
        echo "data: " . json_encode($eventData) . "\n\n";

        ob_flush();
        flush();
    }
}
