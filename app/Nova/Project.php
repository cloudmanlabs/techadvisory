<?php

namespace App\Nova;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Project';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            // ID::make()->sortable(),

            Text::make('Name', 'name')
                ->rules('required')
                ->required(),


            Text::make('Current Phase', 'currentPhase')
                ->exceptOnForms(),


            Boolean::make('Orals', 'hasOrals'),
            Boolean::make('Value Targeting', 'hasValueTargeting'),

            Number::make('Set Up Progress', 'progressSetUp')
                ->exceptOnForms(),
            Number::make('Value Progress', 'progressValue')
                ->exceptOnForms(),
            Number::make('Response Progress', 'progressResponse')
                ->exceptOnForms(),
            Number::make('Analytics Progress', 'progressAnalytics')
                ->exceptOnForms(),
            Number::make('Conclusions Progress', 'progressConclusions')
                ->exceptOnForms(),

            BelongsTo::make('Client', 'client', 'App\Nova\User'),
            BelongsTo::make('Practice', 'practice', 'App\Nova\Practice')
        ];
    }

    public static function relatableUsers(NovaRequest $request, $query)
    {
        return $query->whereIn('userType', User::clientTypes);
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
