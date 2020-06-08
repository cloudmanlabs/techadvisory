<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\User;
use App\UserCredential;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

            'remember' => 'nullable|string'
        ]);

        // There used to be code here to log in with the main client email, but it's removed now. Check git to see it

        $credential = UserCredential::where('email', $request->input('email'))->whereNotNull('password')->first();
        if ($credential == null) {
            return redirect()->back()->withErrors([
                'email' => 'This credentials don\'t correspond to any user in the database.'
            ]);
        }

        $correctPassword = Hash::check($request->input('password'), $credential->password);
        if (!$correctPassword) {
            return redirect()->back()->withErrors([
                'email' => 'This credentials don\'t correspond to any user in the database.'
            ]);
        }

        Log::debug($credential);
        Log::debug($credential->user);

        // At this point we know the credentials are good
        $user = $credential->user;

        if($user == null){
            throw new Exception('You fucked up big time, it shouldn\'t be null here');
        }

        if (!$user->isClient()) {
            return redirect()->back()
                ->withErrors(['notClient' => 'You\'re not a Client User, please use your corresponding login page.']);
        }

        $remember = $request->input('remember') === 'on';
        Auth::login($user, $remember);

        return redirect('/client');
    }
}
