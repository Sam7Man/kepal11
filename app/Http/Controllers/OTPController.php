<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function otp() {
        return view('user.kodeotp');
    }

    public function loginOTPSubmit(Request $request)
    {
        $data = $request->all();
        $data  = User::where([['email', '=', Auth::user()->email], ['otp', '=', $request->otp]])->first();
        if ($data) {
            Auth::login($data, true);
            User::where('email', '=', $request->email)->update(['otp' => null]);
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }
}

