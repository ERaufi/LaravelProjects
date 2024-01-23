<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function create(Request $request)
    {
        $item = new Notifications();
        $item->message = $request->message;
        $item->user_id = $request->id;
        $item->save();
    }
}
