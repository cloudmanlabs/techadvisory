<?php

namespace App\Observers;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;
use App\User;

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
    }
}
