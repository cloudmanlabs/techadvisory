<?php

namespace App\Nova\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class TenYearFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $formatted_date = Carbon::now()->subYears(10)->toDateTimeString();

        switch ($value) {
            case 'old':
                return $query
                    ->where('created_at', '<', $formatted_date);
            case 'new':
                return $query
                    ->where('created_at', '>', $formatted_date);
            default:
                return $query;
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Older than 10 years' => 'old',
            'Newer than 10 years' => 'new',
            'All' => 'all'
        ];
    }
}
