<?php

namespace App\Http\Controllers;

use App\UserCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CredentialController extends Controller
{
    public function changePassword($token)
    {
        $credential = UserCredential::where("passwordChangeToken", $token)->first();
        if($credential == null){
            abort(404);
        }

        return view('credentials.changePassword', [
            'token' => $token,
        ]);
    }

    public function changePasswordPost(Request $request, $token)
    {
        $credential = UserCredential::where("passwordChangeToken", $token)->first();
        if ($credential == null) {
            abort(404);
        }

        $request->validate([
            'password' => 'required|confirmed|string|min:8'
        ]);

        $credential->password = Hash::make($request->password);
        $credential->passwordChangeToken = null;
        $credential->save();

        return redirect()->to('/');
    }

    public function enterEmail()
    {
        return view('credentials.enterEmail');
    }

    public function enterEmailPost(Request $request)
    {
        $request->validate([
            'email' => 'required|string'
        ]);

        /** @var UserCredential $credential */
        $credential = UserCredential::where("email", $request->email)->first();
        if ($credential == null) {
            abort(404);
        }

        $credential->sendPasswordResetEmail();

        return back()->with('status', 'Password reset email sent');
    }
}
