<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 * @property boolean $required
 *
 * @property string $presetOption
 * @property string $options
 *
 * @property string $page
 */
class SelectionCriteriaQuestion extends Question
{
    public $guarded = [];

    const pagesSelect = [
        'fitgap' => 'Fitgap',
        'vendor_corporate' => 'Vendor - Corporate',
        'vendor_market' => 'Vendor - Market',
        'innovation_digitalEnablers' => 'Innovation - Digital Enablers',
        'innovation_alliances' => 'Innovation - Alliacnces',
        'innovation_product' => 'Innovation - Product',
        'innovation_sustainability' => 'Innovation - Sustainability',
        'implementation_implementation' => 'Implementation - Implementation',
        'implementation_run' => 'Implementation - Run',
    ];
}
