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

class UseCaseTemplate extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\UseCaseTemplate';

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
        'id',
        'name',
        'description'
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

            Text::make('Name', 'name')
                ->rules('required')
                ->required(),

            Text::make('Description', 'description')
                ->rules('required')
                ->required(),

            BelongsTo::make('SC Capability (Practice)', 'practice', 'App\Nova\Practice')
                ->sortable(),

            BelongsTo::make('Subpractice', 'subpractice', 'App\Nova\Subpractice')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            HasMany::make('Use Case Questions', 'useCaseQuestions', 'App\Nova\UseCaseTemplateQuestionResponse'),
        ];

        $other = [];

        if ($request->editing && $request->editMode === 'update' && intval(explode('/', $request->fullUrl())[4] === 'use-case-templates')) {
            $useCaseTemplateId = intval(explode('/', $request->fullUrl())[5]);
            $useCaseTemplate = \App\UseCaseTemplate::find($useCaseTemplateId);
            $filteredSubpractices = \App\Subpractice::where('practice_id', '=', $useCaseTemplate->practice_id)->get();
            $options = [];

            foreach ($filteredSubpractices as $filteredSubpractice) {
                $options[$filteredSubpractice->id] = $filteredSubpractice->name;
            }

            array_push($other,
                Select::make('Subpractice', 'subpractice_id')
                    ->options($options)
                    ->nullable()
//                    ->hideFromIndex()
                    ->displayUsingLabels()
                    ->hideWhenCreating()
            );
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
