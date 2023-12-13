<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        $url = 'login';
        return view('auth.login', compact('url'));
    }

    public function adminLogin(Request $request)
    {
        $this->validateLogin($request);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 1
        ])) {
            return redirect()->route('admin');
        }else{
            return back()->withInput($request->input())->withErrors(['error_message' => 'Invalid credential.']);
        }
    }
}
