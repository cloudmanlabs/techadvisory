<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\User;
use App\UserCredential;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


        $user = User::where('email', $request->input('email'))->first();
        if ($user != null) {
            // Loging in with the normal user
            $correctPassword = Hash::check($request->input('password'), $user->password);
            if (!$correctPassword) {
                return redirect()->back()->withErrors([
                    'email' => 'This credentials don\'t correspond to any user in the database.'
                ]);
            }
        } else {
            $credential = UserCredential::where('email', $request->input('email'))->first();
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

            // At this point we know the credentials are good
            $user = $credential->user;
        }

        if ($user == null) {
            throw new Exception('You fucked up big time, it shouldn\'t be null here');
        }

        if (!$user->isVendor()) {
            return redirect()->back()
                ->withErrors(['notVendor' => 'You\'re not a Vendor User, please use your corresponding login page.']);
        }

        $remember = $request->input('remember') ?? false;
        Auth::login($user, $remember);

        return redirect('/vendors');
    }
}
