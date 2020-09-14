<?php

namespace App\Nova\Filters;

use App\GeneralInfoQuestion;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use function _HumbugBoxe251c92b00d9\React\Promise\all;

class PageTypeGeneral extends Filter
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
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        //$valueTranslated =
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
        //return GeneralInfoQuestion::select('page')->groupBy('page')->get()->pluck('page')->toArray();
        $allData = GeneralInfoQuestion::pagesSelect;
        $options = array_keys($allData);
/*        foreach ($allData as $key=>$value){
            $options[$key] = $key;
        }*/
        return $allData;
    }
}
