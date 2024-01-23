<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = User::where('email', $username)
            // ->orWhere('name', $username)
            // ->orWhere('phone', $username)
            ->first();

        if ($user == null || !Hash::check($password, $user->password)) {
            return back()->with('message', 'Incorrect User name or Password');
        }

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }
}
