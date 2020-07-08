<?php

namespace App\Observers;

use App\GeneralInfoQuestionResponse;
use App\ClientProfileQuestionResponse;
use Illuminate\Support\Facades\Log;

class GeneralInfoQuestionResponseObserver
{
    public function created(GeneralInfoQuestionResponse $response)
    {
        $related = $response->originalQuestion->clientProfileQuestion;
        if ($related == null) return;

        $client = $response->project->client;

        if($client == null) return;

        /** @var ClientProfileQuestionResponse|null $clientResponse */
        $clientResponse = ClientProfileQuestionResponse::where('question_id', $related->id)
            ->where('client_id', $client->id)
            ->first();

        if ($clientResponse == null) return;

        $response->response = $clientResponse->response;
        $response->save();
    }
}
