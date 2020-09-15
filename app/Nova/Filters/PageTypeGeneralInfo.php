<?php

namespace App\Nova\Filters;

use App\GeneralInfoQuestion;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use function _HumbugBoxe251c92b00d9\React\Promise\all;

class PageTypeGeneralInfo extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    public $name = 'Page Type (General Info Questions)';

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
        return $query->where('page', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {

        $selectionPageTypes = \App\GeneralInfoQuestion::pagesSelect;
        $options = [];
        // Reverse the arrays values, because Nova works like that.
        foreach ($selectionPageTypes as $key => $value) {
            $options[$value] = $key;
        }
        return $options;
    }
}
