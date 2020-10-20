<?php

namespace App\Nova;

use App\Nova\Actions\ClearNotAddedSelectionCriteriaResponses;
use App\Nova\Filters\TenYearFilter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
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
        'id', 'name', 'currentPhase'
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

            Text::make('Name', 'name')
                ->rules('required')
                ->required(),

            Select::make('Current phase', 'currentPhase')
                ->options([
                    'preparation' => 'Preparation',
                    'open' => 'Open',
                    'old' => 'Old'
                ])
                ->displayUsingLabels()
                ->hideWhenCreating()
                ->hideWhenUpdating(function(){
                    return $this->currentPhase == 'preparation';
                })
                ->sortable(),

            DateTime::make('Deadline', 'deadline')
                ->sortable(),

            Boolean::make('Published analytics', 'publishedAnalytics')
                    ->hideFromIndex(),

            Boolean::make('Is Binding', 'isBinding'),

            Boolean::make('Orals', 'hasOrals'),
            Boolean::make('Value Targeting', 'hasValueTargeting'),

            Boolean::make('Accenture submitted First 3 pages', 'step3SubmittedAccenture')
                ->hideFromIndex(),
            Boolean::make('Client submitted First 3 pages', 'step3SubmittedClient')
                ->hideFromIndex(),
            Boolean::make('Accenture submitted Selection Criteria', 'step4SubmittedAccenture')
                ->hideFromIndex(),
            Boolean::make('Client submitted Selection Criteria', 'step4SubmittedClient')
                ->hideFromIndex(),

            Boolean::make('Has Uploaded Fitgap', 'hasUploadedFitgap')
                ->hideFromIndex(),

            Number::make('Set Up Progress', function(){
                return $this->progressSetUp();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Value Progress', function(){
                return $this->progressValue();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Response Progress', function(){
                return $this->progressResponse();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Analytics Progress', function(){
                return $this->progressAnalytics();
            })
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Conclusions Progress', function(){
                return $this->progressConclusions();
            })
                ->exceptOnForms()
                ->hideFromIndex(),

            BelongsTo::make('Client', 'client', 'App\Nova\Client')
                ->sortable(),
            BelongsTo::make('Practice', 'practice', 'App\Nova\Practice')
                ->sortable(),

			Text::make('Industry', 'industry')
				->canSee(function(){
					return auth()->user()->isAdmin();
                }),
            Text::make('Regions', 'regions')
				->canSee(function(){
					return auth()->user()->isAdmin();
                }),

            Number::make('Fitgap Client Weight: Must', 'fitgapWeightMust')
                ->hideFromIndex()
                ->withMeta([
                    'default' => 10
                ]),
            Number::make('Fitgap Client Weight: Required', 'fitgapWeightRequired')
                ->hideFromIndex(),
            Number::make('Fitgap Client Weight: Nice to have', 'fitgapWeightNiceToHave')
                ->hideFromIndex(),

            Number::make('Fitgap Vendor Weight: Fully supports', 'fitgapWeightFullySupports')
                ->hideFromIndex(),
            Number::make('Fitgap Vendor Weight: Partially supports', 'fitgapWeightPartiallySupports')
                ->hideFromIndex(),
            Number::make('Fitgap Vendor Weight: Planned', 'fitgapWeightPlanned')
                ->hideFromIndex(),
            Number::make('Fitgap Vendor Weight: Not supported', 'fitgapWeightNotSupported')
                ->hideFromIndex(),

            Number::make('Fitgap Detailed Weight: Functional', 'fitgapFunctionalWeight')
                ->hideFromIndex(),
            Number::make('Fitgap Detailed Weight: Technical', 'fitgapTechnicalWeight')
                ->hideFromIndex(),
            Number::make('Fitgap Detailed Weight: Service', 'fitgapServiceWeight')
                ->hideFromIndex(),
            Number::make('Fitgap Detailed Weight: Others', 'fitgapOthersWeight')
                ->hideFromIndex(),

            Number::make('Implementation Detailed Weight: Implementation', 'implementationImplementationWeight')
                ->hideFromIndex(),
            Number::make('Implementation Detailed Weight: Run', 'implementationRunWeight')
                ->hideFromIndex(),

            BelongsToMany::make('Subpractices', 'subpractices', 'App\Nova\Subpractice'),

            HasMany::make('General Info Questions', 'generalInfoQuestions', 'App\Nova\GeneralInfoQuestionResponse'),
            HasMany::make('Sizing Questions', 'sizingQuestions', 'App\Nova\SizingQuestionResponse'),

            HasMany::make('Selection Criteria Questions', 'selectionCriteriaQuestionsPivots', 'App\Nova\SelectionCriteriaQuestionProjectPivot'),
            HasMany::make('Selection Criteria Responses', 'selectionCriteriaQuestions', 'App\Nova\SelectionCriteriaQuestionResponse'),

            HasMany::make('Applied vendors', 'vendorApplications', 'App\Nova\VendorApplication'),

            (new Panel('Debug', [
                Boolean::make('Has Value Targetting files in each', function(){
                    return $this->hasValueTargetingFilesInEach();
                })->canSee(function () {
                    return auth()->user()->isAdmin();
                }),
                Boolean::make('Has Completed business opportunity', function(){
                    return $this->hasCompletedBusinessOpportunity();
                })->canSee(function () {
                    return auth()->user()->isAdmin();
                }),
            ])),
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
            (new ClearNotAddedSelectionCriteriaResponses())
        ];
    }
}
