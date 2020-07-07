<?php

namespace App\Observers;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\SecurityLog;
use App\User;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user)
    {
        if($user->isClient()){
            foreach (ClientProfileQuestion::all() as $question) {
                $response = new ClientProfileQuestionResponse([
                    'question_id' => $question->id,
                    'client_id' => $user->id,
                    ]);
                $response->save();
            }
        }

        if ($user->isVendor()) {
            foreach (VendorProfileQuestion::all() as $question) {
                $response = new VendorProfileQuestionResponse([
                    'question_id' => $question->id,
                    'vendor_id' => $user->id,
                ]);
                $response->save();
            }
        }

        $folder = Folder::createNewRandomFolder();
        $user->profileFolder()->save($folder);

        SecurityLog::createLog('User created User with ID ' . $user->id);
    }

    public function deleting(User $user)
    {
        foreach ($user->vendorApplications as $application) {
            $application->delete();
        }
        foreach ($user->vendorSolutions as $solution) {
            $solution->delete();
        }
        foreach($user->credentials as $credential){
            $credential->delete();
        }
    }
}
