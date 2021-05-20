<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Silvanite\NovaFieldCheckboxes\Checkboxes;
use App\User;

class UserCredential extends Resource
{
    public static function availableForNavigation(Request $request)
    {
        return auth()->user()->isAdmin();
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\UserCredential';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'email', 'passwordChangeToken',
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
              ID::make()->sortable(),

              Text::make('Name')
                  ->sortable()
                  ->rules('required', 'max:255'),

              Text::make('Email')
                  ->sortable()
                  ->rules('required', 'email', 'max:254'),


              Boolean::make('Hidden', 'hidden'),

              Text::make('Change password link', function () {
                  return $this->passwordChangeLink();
              }),

              BelongsTo::make('User', 'user'),

              Select::make('Vendor user type', 'vendor_user_type')
                  ->options([
                      '1' => 'Internal User',
                      '2' => 'External User'
                  ])
                  ->displayUsingLabels(),

              HasMany::make('Visible Projects', 'visibleProjects', \App\Nova\VisibleProject::class),


              // Password::make('Password')
              //     ->onlyOnForms()
              //     ->creationRules('required', 'string', 'min:8')
              //     ->updateRules('nullable', 'string', 'min:8'),
          ];

    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->isAdmin()) {
            return $query;
        } else {
            return $query->where('hidden', false);
        }
    }

    public static function relatableUsers(NovaRequest $request, $query)
    {
        if ($request->viaResource == 'clients') {
            if ($request->viaRelationship == 'credentials') {
                return $query->where('id', $request->viaResourceId);
            } else {
                return $query->whereIn('userType', \App\User::clientTypes);
            }
        }

        if ($request->viaResource == 'vendors') {
            if ($request->viaRelationship == 'credentials') {
                return $query->where('id', $request->viaResourceId);
            } else {
                return $query->whereIn('userType', \App\User::vendorTypes);
            }
        }

        return $query;
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
