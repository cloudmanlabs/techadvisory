<?php

namespace Laravel\Nova\Fields;

class VendorEvaluation extends Select
{
    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->options([
            0 => __('not existing'),
            2 => __('existing but too weak'),
            4 => __('not satisfied / not efficient'),
            6 => __('satisfied / acceptable'),
            8 => __('very satisfied / efficient'),
            10 => __('extremely satisfied / succeeds expectations'),
        ]);
    }
}
