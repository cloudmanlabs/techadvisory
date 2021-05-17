<?php

namespace App\Observers;

use App\Mail\NewCredentialMail;
use App\UserCredential;
use App\VendorVisibleProject;
use Illuminate\Support\Facades\Mail;

class UserCredentialObserver
{
    public function creating(UserCredential $credential)
    {
        if ($credential->vendor_user_type == 2) {
            $visible_projects = explode(", ", request()->projects);
            foreach ($visible_projects as $key => $project) {
              VendorVisibleProject::create(['project_id' => $project->id, 'user_credential_id' => $credential->id]);
            }
        }
    }

    public function created(UserCredential $credential)
    {
        // $credential->sendSignUpEmail();
    }
}
