<?php

namespace App\Nova\Filters;

use App\Practice;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PracticeType extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    public $name = 'SC Capability (Practice) filter';

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
        return $query->where('practice_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        $options = [];
        $practices = Practice::get();
        foreach ($practices as $key => $practice) {
            $options[$practice->name] = $practice->id;
        }

        return $options;
    }
}
