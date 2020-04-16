<?php

namespace App\Observers;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;
use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user)
    {
        if($user->isClient()){
            foreach (ClientProfileQuestion::all() as $key => $question) {
                $response = new ClientProfileQuestionResponse([
                    'question_id' => $question->id,
                    'client_id' => $user->id,
                    ]);
                $response->save();
            }
        }

        if ($user->isVendor()) {
            foreach (VendorProfileQuestion::all() as $key => $question) {
                $response = new VendorProfileQuestionResponse([
                    'question_id' => $question->id,
                    'vendor_id' => $user->id,
                ]);
                $response->save();
            }
        }
    }
}
