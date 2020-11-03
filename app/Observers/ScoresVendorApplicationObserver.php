<?php

namespace App\Observers;

use App\vendorApplication;

class ScoresVendorApplicationObserver
{
    /**
     * Handle the vendor application "created" event.
     * Calculate and save the scores from the application for the initial state.
     *
     * @param  \App\vendorApplication  $vendorApplication
     * @return void
     */
    public function created(vendorApplication $vendorApplication)
    {
/*        $overallScore = 0;
        $rankingScore = 0;

        $vendorApplication->overall_score = $overallScore;
        $vendorApplication->ranking_score = $rankingScore;
        $vendorApplication->save();*/
    }

    /**
     * Handle the vendor application "updated" event.
     *
     * @param  \App\vendorApplication  $vendorApplication
     * @return void
     */
    public function updated(vendorApplication $vendorApplication)
    {
        $overallScore = $vendorApplication->totalScore();
        $rankingScore = $vendorApplication->ranking();

        $vendorApplication->overall_score = $overallScore;
        $vendorApplication->ranking_score = $rankingScore;
        $vendorApplication->save();
    }

    /**
     * Handle the vendor application "deleted" event.
     *
     * @param  \App\vendorApplication  $vendorApplication
     * @return void
     */
    public function deleted(vendorApplication $vendorApplication)
    {
        //
    }

    /**
     * Handle the vendor application "restored" event.
     *
     * @param  \App\vendorApplication  $vendorApplication
     * @return void
     */
    public function restored(vendorApplication $vendorApplication)
    {
        //
    }

    /**
     * Handle the vendor application "force deleted" event.
     *
     * @param  \App\vendorApplication  $vendorApplication
     * @return void
     */
    public function forceDeleted(vendorApplication $vendorApplication)
    {
        //
    }
}
