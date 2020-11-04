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


        $vendorApplication = VendorApplication::where([
            'project_id' => $response->project->id,
            'vendor_id' => $response->vendor->id
        ])->first();

        $vendorApplication->overall_score = $vendorApplication->totalScore();
        $vendorApplication->ranking_score = $vendorApplication->ranking();

        $vendorApplication->fitgap_score = $vendorApplication->fitgapScore();

        $vendorApplication->fitgap_functional_score = $vendorApplication->fitgapFunctionalScore();
        $vendorApplication->fitgap_technical_score = $vendorApplication->fitgapTechnicalScore();
        $vendorApplication->fitgap_service_score = $vendorApplication->fitgapServiceScore();
        $vendorApplication->fitgap_others_score = $vendorApplication->fitgapOtherScore();

        $vendorApplication->vendor_score = $vendorApplication->vendorScore();
        $vendorApplication->experience_score = $vendorApplication->experienceScore();
        $vendorApplication->innovation_score = $vendorApplication->innovationScore();

        $vendorApplication->implementation_score = $vendorApplication->implementationScore();
        $vendorApplication->implementation_implementation_score = $vendorApplication->implementationImplementationScore();
        $vendorApplication->implementation_run_score = $vendorApplication->implementationRunScore();

        $vendorApplication->save();
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
