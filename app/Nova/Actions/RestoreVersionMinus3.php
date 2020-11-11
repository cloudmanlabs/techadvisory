<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class RestoreVersionMinus3 extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = "Restore Fitgap version minus 3";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $vendorApplication) {
            $old = $vendorApplication->fitgapVendorColumnsOld3;
            $vendorApplication->fitgapVendorColumnsOld3 = $vendorApplication->fitgapVendorColumns;
            $vendorApplication->fitgapVendorColumns = $old;
            $vendorApplication->save();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
