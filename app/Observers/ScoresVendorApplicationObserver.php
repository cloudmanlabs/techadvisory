<?php

namespace App\Observers;

use App\vendorApplication;

class ScoresVendorApplicationObserver
{
    /**
     * Handle the vendor application "created" event.
     * @param \App\vendorApplication $vendorApplication
     * @return void
     */
    public function created(vendorApplication $vendorApplication)
    {

    }

    /**
     * Handle the vendor application "updated" event.
     * Calculate and save the scores from the application for the initial state.
     * @param \App\vendorApplication $vendorApplication
     * @return void
     */
    public function updated(vendorApplication $vendorApplication)
    {
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
    }

    /**
     * Handle the vendor application "deleted" event.
     *
     * @param \App\vendorApplication $vendorApplication
     * @return void
     */
    public function deleted(vendorApplication $vendorApplication)
    {
        //
    }

    /**
     * Handle the vendor application "restored" event.
     *
     * @param \App\vendorApplication $vendorApplication
     * @return void
     */
    public function restored(vendorApplication $vendorApplication)
    {
        //
    }

    /**
     * Handle the vendor application "force deleted" event.
     *
     * @param \App\vendorApplication $vendorApplication
     * @return void
     */
    public function forceDeleted(vendorApplication $vendorApplication)
    {
        //
    }
}
