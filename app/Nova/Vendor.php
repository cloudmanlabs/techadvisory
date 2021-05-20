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
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outhebox\NovaHiddenField\HiddenField;
use Illuminate\Support\Str;

class Vendor extends Resource
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
            ID::make('Id', 'id'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Image::make('logo')
                ->exceptOnForms(),

            Text::make('Export Credentials', function () {
                $url = "/accenture/exportCredentials/{$this->id}";
                return "<a href='{$url}' target='_blank' style='text-decoration: none;'>Download excel</a>";
            })
                ->hideFromIndex()
                ->asHtml(),

            // This sets the correct value for userType
            HiddenField::make('userType')
                ->hideFromIndex()
                ->hideFromDetail()
                ->default('vendor'),


            HiddenField::make('password')
                ->onlyOnForms()
                ->hideWhenUpdating()
                ->default('password'),

            HiddenField::make('email')
                ->onlyOnForms()
                ->hideWhenUpdating()
                ->default(Str::random() . '@example.com'),

            HasMany::make('Other Login Credentials', 'credentials', \App\Nova\UserCredential::class),

            HasMany::make('Profile Questions', 'vendorProfileQuestions', 'App\Nova\VendorProfileQuestionResponse'),
            HasMany::make('Solutions', 'vendorSolutions', 'App\Nova\VendorSolution'),

            HasMany::make('Applied projects', 'vendorAppliedProjects', 'App\Nova\Project'),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereIn('userType', User::vendorTypes);
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
