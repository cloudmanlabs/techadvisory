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
        //
    }

    /**
     * Handle the selection criteria question response "updated" event.
     * Calculate and save the scores from the application for the initial state.
     * @param SelectionCriteriaQuestionResponse $response
     * @return void
     */
    public function updated(SelectionCriteriaQuestionResponse $response)
    {
        // Se podria intentar actualizar todas solo si la score ha cambiado.

        $vendorApplication = $response->vendorApplication();
        $vendorApplication->updateMyScores();
    }
    
    /**
     * Handle the selection criteria question response "deleted" event.
     *
     * @param SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse
     * @return void
     */
    public function deleted(SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse)
    {
        //
    }

    /**
     * Handle the selection criteria question response "restored" event.
     *
     * @param SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse
     * @return void
     */
    public function restored(SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse)
    {
        //
    }

    /**
     * Handle the selection criteria question response "force deleted" event.
     *
     * @param SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse
     * @return void
     */
    public function forceDeleted(SelectionCriteriaQuestionResponse $selectionCriteriaQuestionResponse)
    {
        //
    }
}
