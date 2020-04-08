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

class SizingQuestion extends Resource
{
    public static $group = 'Questions';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\SizingQuestion';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $common = [
            Select::make('Type', 'type')
                ->options([
                    'text' => 'Text',
                    'textarea' => 'Text Area',
                    'selectSingle' => 'Select',
                    'selectMultiple' => 'Select multiple',
                    'date' => 'Date'
                ])
                ->displayUsingLabels()
                ->rules('required'),

            Text::make('Label', 'label')
                ->required(),
            Boolean::make('Required', 'required'),

            BelongsTo::make('Practice', 'practice', 'App\Nova\Practice')
                ->nullable()
                ->help('Select a Practice if you want this Question to only show on projects with that Practice')
        ];

        switch ($this->resource->type) {
            default:
                $other = [];
                break;
        }

        return array_merge($common, $other);
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
