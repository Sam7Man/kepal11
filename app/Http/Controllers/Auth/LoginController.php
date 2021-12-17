<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\SendEmail;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function login(Request $request) {
        $data = $request->all();
        
        // User::where(['email' => $data['email'], 'password' => $password, 'status' => 'active'])->get()

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // Session::put('user', $data['email']);
            // request()->session()->flash('success', 'Silahkan Cek Email Anda dan MAsukkan Kode OTP Disini');
            $otp = rand(1000, 9999);
            User::where('email', $request->email)->update(['otp' => $otp]);

            $data = ['email' => $request->email, 'otp' => $otp];
            SendEmail::sendToUser($data);

            return redirect()->route('user.kodeotp');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }


    protected function redirectTo()
    {
        if (auth()->user()->role == 'admin') {
            return '/admin';
        }
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
}
