<?php

namespace App\Observers;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;

class ScoresVendorApplicationAfterResponse
{
    /**
     * Handle the selection criteria question response "created" event.
     *
     * @param SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse
     * @return void
     */
    public function created(SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse)
    {
        // If the response is created, the score is null, not 0. Not evaluated yet.
        // The scores from vendor application can't be updated until the response has a score [0-10]
    }

    /**
     * Handle the selection criteria question response "updated" event.
     * Calculate and save the scores from the application for the initial state.
     * @param SelectionCriteriaQuestionResponse $response
     * @return void
     */
    public function updated(SelectionCriteriaQuestionResponse $response)
    {

        $vendorApplication = $response->vendorApplication();
        $vendorApplication->updateMyScores();
    }

    /**
     * Handle the selection criteria question response "deleted" event.
     *
     * @param SelectionCriteriaQuestionResponse $response
     * @return void
     */
    public function deleted(SelectionCriteriaQuestionResponse $response)
    {
        $vendorApplication = $response->vendorApplication();
        $vendorApplication->updateMyScores();
    }

    /**
     * Handle the selection criteria question response "restored" event.
     *
     * @param SelectionCriteriaQuestionResponse $response
     * @return void
     */
    public function restored(SelectionCriteriaQuestionResponse $response)
    {
        $vendorApplication = $response->vendorApplication();
        $vendorApplication->updateMyScores();
    }

    /**
     * Handle the selection criteria question response "force deleted" event.
     *
     * @param SelectionCriteriaQuestionResponse $response
     * @return void
     */
    public function forceDeleted(SelectionCriteriaQuestionResponse $response)
    {
        $vendorApplication = $response->vendorApplication();
        $vendorApplication->updateMyScores();
    }
}
