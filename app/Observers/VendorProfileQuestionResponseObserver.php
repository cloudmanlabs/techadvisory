<?php

namespace App\Observers;

use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\VendorProfileQuestionResponse;
use Illuminate\Support\Facades\Log;

class VendorProfileQuestionResponseObserver
{
    public function saved(VendorProfileQuestionResponse $response)
    {
        $vendor = $response->vendor;
        $dependents = $response->originalQuestion->dependentSelectionCriteriaQuestions;

        // We get all the SelectionCriteriaQuestionResponses that belong to this vendor
        $selectionResponses = $dependents
            ->flatMap(function(SelectionCriteriaQuestion $dependent){
                return $dependent->responses;
            })
            ->filter(function(SelectionCriteriaQuestionResponse $response) use ($vendor) {
                return $response->vendor->is($vendor);
            });

        // Then we update them with the new answer if it's empty
        foreach ($selectionResponses as $key => $selectionResponse) {
            /** @var \App\SelectionCriteriaQuestionResponse $selectionResponse */
            if(
                $selectionResponse->response == null
                || $selectionResponse->response == ""
                || $selectionResponse->response == "[]"
            ){
                $selectionResponse->response = $response->response;
                $selectionResponse->save();
            }
        }
    }
}
