<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use App\Models\PushNotificationMsgs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;


class PushNotificationController extends Controller
{
    //
    public function sendNotification(Request $request)
    {
        $auth = [
            'VAPID' => [
                'subject' => 'https://laravelprojects.test/', // can be a mailto: or your website address
                'publicKey' => env('PUSH_NOTIFICATION_PUBLIC_KEY'), // (recommended) uncompressed public key P-256 encoded in Base64-URL
                'privateKey' => env('PUSH_NOTIFICATION_PRIVATE_KEY'), // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
            ],
        ];

        $webPush = new WebPush($auth);
        // $payload = '{"title":"' . $request->title . '" , "body":"' . $request->body . '" , "url":"./?id=' . $request->idOfProduct . '"}';

        // Construct the payload with the logo
        $payload = json_encode([
            'title' => $request->title,
            'body' => $request->body,
            'url' => './?id=' . $request->idOfProduct,
        ]);

        $msg = new PushNotificationMsgs();
        $msg->title = $request->title;
        $msg->body = $request->body;
        $msg->url = $request->idOfProduct;
        $msg->save();



        $notifications = PushNotification::all();

        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create($notification['subscriptions']),
                $payload,
                ['TTL' => 5000]
            );
        }

        return response()->json(['message' => 'send successfully'], 200);
    }

    public function saveSubscription(Request $request)
    {
        $items = new PushNotification();
        $items->subscriptions = json_decode($request->sub);
        $items->save();

        return response()->json(['message' => 'added successfully'], 200);
    }
}
