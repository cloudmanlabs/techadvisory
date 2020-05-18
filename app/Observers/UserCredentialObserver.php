<?php

namespace App\Observers;

use App\Mail\NewCredentialMail;
use App\UserCredential;
use Illuminate\Support\Facades\Mail;

class UserCredentialObserver
{
    public function created(UserCredential $credential)
    {
        Mail::to($credential->email)->send(new NewCredentialMail($credential));
    }
}
