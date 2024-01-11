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
        $request->session()->put('lang', $request->lang);
        return redirect()->back();
    }
}
