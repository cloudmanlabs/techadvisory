<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class FixedTypeSelectionCriteriaOnProject extends BooleanFilter
{
    public $name = 'Fixed Questions are disabled';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $query->join('selection_criteria_questions', 'selection_criteria_question_project_pivots.question_id',
            '=', 'selection_criteria_questions.id')
        ->where('selection_criteria_questions.fixed', '!=', 1);
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
        ];
    }
}
