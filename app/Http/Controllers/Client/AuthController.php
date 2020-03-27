<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',

            'remember' => 'nullable|boolean'
        ]);

        // Check if the user is Accenture
        $user = User::where('email', $request->input('email'))->first();
        if ( ! $user->isClient()){
            return redirect()->back()
                    ->withErrors(['notClient' => 'You\'re not a Client User, please use your corresponding login page.']);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember') ?? false;

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('client.home');
            // return redirect()->intended(route('client.home'));
        }
    }
}
