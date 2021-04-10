<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\SecurityLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if the user is Accenture
        $user = User::where('email', $request->input('email'))->first();
        if ($user == null || !$user->isAccenture()) {
            return redirect()->back()
                ->withErrors(['notAccenture' => 'You\'re not an Accenture User, please use your corresponding login page.']);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember') == 'on';

        if (Auth::attempt($credentials, $remember)) {
            SecurityLog::createLog('User logged in', 'Auth');

            return redirect()->route('accenture.home');
            // return redirect()->intended(route('accenture.home'));
        } else {
            return redirect()->back()->withErrors([
                'email' => 'This credentials don\'t correspond to any user in the database.',
            ]);
        }
    }
}
