<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    //
    public function change(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // If the user is logged in, update the language in the users table
            $user->lang = $request->lang;
            $user->update();
        } else {
            // If the user is not logged in, store the language in the session
            $request->session()->put('lang', $request->lang);
        }

        // Redirect back or wherever you want to go after changing the language
        return redirect()->back();
    }
}
