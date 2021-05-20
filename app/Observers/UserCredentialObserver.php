<?php

namespace App\Observers;

use App\Mail\NewCredentialMail;
use App\UserCredential;
use Illuminate\Support\Facades\Mail;

class UserCredentialObserver
{
    public function created(UserCredential $credential)
    {
        // $credential->sendSignUpEmail();
    }
}
