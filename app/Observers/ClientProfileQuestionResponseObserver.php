<?php

namespace App\Observers;

use App\ClientProfileQuestionResponse;
use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;

class ClientProfileQuestionResponseObserver
{
    public function saved(ClientProfileQuestionResponse $response)
    {
        $client = $response->client;
        $dependents = $response->originalQuestion->dependentGeneralInfoQuestions;

        // We get all the GeneralInfoQuestionResponses that belong to this client
        $selectionResponses = $dependents
            ->flatMap(function (GeneralInfoQuestion $dependent) {
                return $dependent->responses;
            })
            ->filter(function (GeneralInfoQuestionResponse $response) use ($client) {
                if($response->project->client != null){
                    return $response->project->client->is($client);
                }
                return false;
            });

        // Then we update them with the new answer if it's empty
        foreach ($selectionResponses as $key => $selectionResponse) {
            /** @var \App\GeneralInfoQuestionResponse $selectionResponse */
            if (
                $selectionResponse->response == null
                || $selectionResponse->response == ""
                || $selectionResponse->response == "[]"
            ) {
                $selectionResponse->response = $response->response;
                $selectionResponse->save();
            }
        }
    }
}
