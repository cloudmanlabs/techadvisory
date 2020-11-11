<?php

namespace App\Nova\Filters;

use App\Nova\SelectionCriteriaQuestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PageTypeSelectionCriteriaOnProject extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    public $name = 'Page Type (Selection Criteria Questions)';


    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query
            ->join('selection_criteria_questions', 'selection_criteria_question_project_pivots.question_id',
                '=', 'selection_criteria_questions.id')
            ->where('selection_criteria_questions.page', 'LIKE', $value)
            ->where('selection_criteria_questions.fixed', '=', 0);
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request)
    {

        $selectionPageTypes = \App\SelectionCriteriaQuestion::pagesSelect;
        $options = [];
        // Reverse the arrays values, because Nova works like that.
        foreach ($selectionPageTypes as $key => $value) {
            $options[$value] = $key;
        }

        return $options;
    }
}
