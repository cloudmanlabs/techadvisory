<?php

namespace App\Nova\Actions;

use App\Exports\MultiUserCredentialExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Facades\Excel;

class ExportCredentials extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $users
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $users)
    {
        $export = new MultiUserCredentialExport($users);

        $filename = 'excel/credentials_export_' . date('mdyhi') . '.xlsx';

        Excel::store($export, $filename, 'public');

        return Action::download(Storage::disk('public')->url($filename), $filename);
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
