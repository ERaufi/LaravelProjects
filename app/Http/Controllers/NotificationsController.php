<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function index()
    {
        $users = User::all();

        return view('sse', compact('users'));
    }

    public function create(Request $request)
    {
        $item = new Notifications();
        $item->message = $request->message;
        $item->user_id = $request->id;
        $item->save();

        return response()->json('Added Successfully');
    }
}
