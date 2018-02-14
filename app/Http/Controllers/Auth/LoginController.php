<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override redirect URL after authenticated.
     *
     * @return string
     */
    public function redirectPath(): string
    {
        return route('admin.dashboard');
    }

    /**
     * Add function after user logged in successfully.
     */
    public function authenticated()
    {
        $user = Auth::user();
        $user->notify(new GeneralNotification(
            __('Logged in into admin system.'),
            '',
            'fa-unlock-alt'
        ));

        Session::flash('success', sprintf('Welcome to dashboard panel, %s!', Auth::user()->name));
    }
}
