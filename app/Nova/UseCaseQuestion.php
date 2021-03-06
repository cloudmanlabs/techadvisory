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
use Laravel\Nova\Fields\Textarea;

class UseCaseQuestion extends Resource
{
    public static $group = 'Questions';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\UseCaseQuestion';

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
            ID::make()->sortable(),

            Text::make('Label', 'label')
                ->required()
                ->displayUsing(function ($text) {
                    if (strlen($text) > 30) {
                        return substr($text, 0, 30) . '...';
                    }
                    return $text;
                }),

            Select::make('Type', 'type')
                ->options(\App\UseCaseQuestion::selectTypesDisplay)
                ->displayUsingLabels()
                ->exceptOnForms(),
            Select::make('Type', 'type')
                ->options(\App\UseCaseQuestion::selectTypesEdit)
                ->displayUsingLabels()
                ->rules('required')
                ->onlyOnForms()
                ->help('In order to include options for Select and Select Multiple, please click on edit'),

            Boolean::make('Required', 'required'),

            BelongsTo::make('SC Capability (Practice)', 'practice', \App\Nova\Practice::class)
                ->nullable()
                ->help('Select a Practice if you want this Question to only show on projects with that Practice'),
        ];

        // NOTE All of the fields here should be hidden on index and create
        switch ($this->resource->type) {
            case 'text':
                $other = [
                    Text::make('Placeholder', 'placeholder')
                        ->hideWhenCreating()
                        ->hideFromIndex(),
                ];
                break;
            case 'selectSingle':
                $other = [
                    Text::make('Placeholder', 'placeholder')
                        ->hideWhenCreating()
                        ->hideFromIndex(),
                    Select::make('Options', 'presetOption')
                        ->options([
                            'countries' => 'Countries',
                            'transportModes' => 'Transport Modes',
                            'transportFlows' => 'Transport Flows',
                            'transportTypes' => 'Transport Types',
                            'currencies' => 'Currencies',
                            'projectTypes' => 'Project Types',
                            'custom' => 'Custom'
                        ])
                        ->displayUsingLabels()
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->help('Select a preset of options for the Dropdown, or select Custom to add a custom list of options in "Custom options"'),
                    Text::make('Custom options', 'options')
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->help('Add a list of comma separated options.'),
                ];
                break;
            case 'selectMultiple':
                $other = [
                    Select::make('Options', 'presetOption')
                        ->options([
                            'countries' => 'Countries',
                            'transportModes' => 'Transport Modes',
                            'transportFlows' => 'Transport Flows',
                            'transportTypes' => 'Transport Types',
                            'custom' => 'Custom'
                        ])
                        ->displayUsingLabels()
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->help('Select a preset of options for the Dropdown, or select Custom to add a custom list of options in "Custom options"'),
                    Text::make('Custom options', 'options')
                        ->onlyOnForms()
                        ->hideFromIndex()
                        ->hideWhenCreating()
                        ->help('Add a list of comma separated options.'),
                ];
                break;
            case 'textarea':
                $other = [
                    Textarea::make('Placeholder', 'placeholder')
                        ->hideWhenCreating()
                        ->hideFromIndex(),
                ];
                break;
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
