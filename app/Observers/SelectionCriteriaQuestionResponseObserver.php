<?php

namespace App\Observers;

use App\SelectionCriteriaQuestionResponse;
use App\VendorProfileQuestionResponse;

class SelectionCriteriaQuestionResponseObserver
{
    public function created(SelectionCriteriaQuestionResponse $response)
    {
        $related = $response->originalQuestion->vendorProfileQuestion;
        if($related == null) return;

        $vendor = $response->vendor;

        /** @var VendorProfileQuestionResponse|null $vendorResponse */
        $vendorResponse = VendorProfileQuestionResponse::where('question_id', $related->id)
            ->where('vendor_id', $vendor->id)
            ->first();

        if($vendorResponse == null) return;

        $response->response = $vendorResponse->response;
        $response->save();
    }
}
