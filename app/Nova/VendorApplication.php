<?php

namespace App\Nova;

use App\Nova\Actions\RestoreVersionMinus1;
use App\Nova\Actions\RestoreVersionMinus2;
use App\Nova\Actions\RestoreVersionMinus3;
use App\Nova\Actions\RestoreVersionMinus4;
use App\Nova\Actions\RestoreVersionMinus5;
use App\Nova\Actions\RestoreVersionMinus6;
use App\Nova\Actions\RestoreVersionMinus7;
use App\Nova\Actions\RestoreVersionMinus8;
use App\Nova\Actions\RestoreVersionMinus9;
use App\Nova\Actions\RestoreVersionMinus10;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class VendorApplication extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\VendorApplication';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $phaseOptions = [
            'invitation' => 'Invitation',
            'applicating' => 'Applicating',
            'pendingEvaluation' => 'Pending evaluation',
            'evaluated' => 'Evaluated',
            'submitted' => 'Submitted',
            'disqualified' => 'Disqualified',
            'rejected' => 'Rejected',
        ];

        switch ($this->phase) {
            case 'applicating':
                $phaseOptions = [
                    'invitation' => 'Invitation',
                    'applicating' => 'Applicating',
                    'pendingEvaluation' => 'Pending evaluation',
                    'disqualified' => 'Disqualified',
                ];
                break;
            case 'pendingEvaluation':
                $phaseOptions = [
                    'applicating' => 'Applicating',
                    'pendingEvaluation' => 'Pending evaluation',
                    'evaluated' => 'Evaluated',
                    'disqualified' => 'Disqualified',
                ];
                break;
            case 'evaluated':
                $phaseOptions = [
                    'pendingEvaluation' => 'Pending evaluation',
                    'evaluated' => 'Evaluated',
                    'submitted' => 'Submitted',
                    'disqualified' => 'Disqualified',
                ];
                break;
            case 'submitted':
                $phaseOptions = [
                    'evaluated' => 'Evaluated',
                    'submitted' => 'Submitted',
                    'disqualified' => 'Disqualified',
                ];
                break;
            case 'disqualified':
                $phaseOptions = [
                    'invitation' => 'Invitation',
                    'applicating' => 'Applicating',
                    'pendingEvaluation' => 'Pending evaluation',
                    'evaluated' => 'Evaluated',
                    'submitted' => 'Submitted',
                    'disqualified' => 'Disqualified',
                ];
                break;
            case 'rejected':
                $phaseOptions = [
                    'invitation' => 'Invitation',
                    'applicating' => 'Applicating',
                    'rejected' => 'Rejected',
                ];
                break;
        }

        return [
            BelongsTo::make('Vendor', 'vendor', Vendor::class)
                ->exceptOnForms()
                ->sortable(),

            Select::make('Phase', 'phase')->options($phaseOptions)
                ->displayUsingLabels()
                ->sortable(),

            Boolean::make('Invited to Orals', 'invitedToOrals'),
            Boolean::make('Orals completed', 'oralsCompleted'),

            Number::make('Fitgap Progress', function () {
                return $this->progressFitgap();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Vendor Progress', function () {
                return $this->progressVendor();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Experience Progress', function () {
                return $this->progressExperience();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Innovation Progress', function () {
                return $this->progressInnovation();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Implementation Progress', function () {
                return $this->progressImplementation();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Submit Progress', function () {
                return $this->progressSubmit();
            })
                ->exceptOnForms()
                ->hideFromIndex(),

            (new Panel('Fitgap versions', [
                Code::make('Current version', 'fitgapVendorColumns')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 1', 'fitgapVendorColumnsOld')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 2', 'fitgapVendorColumnsOld2')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 3', 'fitgapVendorColumnsOld3')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 4', 'fitgapVendorColumnsOld4')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 5', 'fitgapVendorColumnsOld5')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 6', 'fitgapVendorColumnsOld6')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 7', 'fitgapVendorColumnsOld7')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 8', 'fitgapVendorColumnsOld8')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 9', 'fitgapVendorColumnsOld9')->json()->exceptOnForms()->hideFromIndex(),
                Code::make('Version - 10', 'fitgapVendorColumnsOld10')->json()->exceptOnForms()->hideFromIndex(),
            ])),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new RestoreVersionMinus1),
            (new RestoreVersionMinus2),
            (new RestoreVersionMinus3),
            (new RestoreVersionMinus4),
            (new RestoreVersionMinus5),
            (new RestoreVersionMinus6),
            (new RestoreVersionMinus7),
            (new RestoreVersionMinus8),
            (new RestoreVersionMinus9),
            (new RestoreVersionMinus10),
        ];
    }
}
