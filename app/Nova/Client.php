<?php

namespace App\Nova;

use App\Nova\Actions\ExportCredentials;
use App\Nova\Filters\TenYearFilter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outhebox\NovaHiddenField\HiddenField;

class Client extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\User';

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
        'id', 'name',
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


            Image::make('logo')
                ->exceptOnForms(),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Text::make('Export Credentials', function () {
                $url = "/accenture/exportCredentials/{$this->id}";
                return "<a href='{$url}' target='_blank' style='text-decoration: none;'>Download excel</a>";
            })
                ->hideFromIndex()
                ->asHtml(),

            HasMany::make('Projects', 'projectsClient', \App\Nova\Project::class),

            // This sets the correct value for userType
            HiddenField::make('userType')
                ->hideFromIndex()
                ->hideFromDetail()
                ->default('client'),

            HasMany::make('Other Login Credentials', 'credentials', \App\Nova\UserCredential::class),

            HasMany::make('Profile Questions', 'clientProfileQuestions', \App\Nova\ClientProfileQuestionResponse::class),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
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
        return [
            (new TenYearFilter)
        ];
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
            (new ExportCredentials)
        ];
    }
}
