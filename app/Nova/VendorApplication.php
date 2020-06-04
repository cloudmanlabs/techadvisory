<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
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
        return [];
    }
}
