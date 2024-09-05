<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Notifications;
use App\Models\PushNotification;
use App\Models\PushNotificationMsgs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showAdminTables()
    {
        if (Auth::user()->id == 1) {
            $chats = Chats::all();
            $notifications = Notifications::all();
            $pushNotifications = PushNotification::count();
            $pushNotificationMessages = PushNotificationMsgs::all();

            return view('admin', compact(
                'chats',
                'notifications',
                'pushNotifications',
                'pushNotificationMessages'
            ));
        }

        return abort(404);
    }

    public function deleteAdmin()
    {
        if (Auth::user()->id == 1) {
            Chats::query()->delete();
            Notifications::query()->delete();
            PushNotification::query()->delete();
            PushNotificationMsgs::query()->delete();

            return 'successful';
        }

        return abort(404);
    }
}
