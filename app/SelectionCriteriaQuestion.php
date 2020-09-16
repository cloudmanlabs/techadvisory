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
 *
 * @property boolean $fixed
 * @property string $fixedQuestionIdentifier
 *
 * @property \Illuminate\Support\Collection $responses
 * @property VendorProfileQuestion|null $vendorProfileQuestion
 */
class SelectionCriteriaQuestion extends Question
{
    public $guarded = [];

    const pagesSelect = [
        'fitgap' => 'Fitgap',
        'vendor_corporate' => 'Vendor - Corporate',
        'vendor_market' => 'Vendor - Market',
        'experience' => 'Experience',
        'innovation_digitalEnablers' => 'Innovation - Digital Enablers',
        'innovation_alliances' => 'Innovation - Alliances',
        'innovation_product' => 'Innovation - Product',
        'innovation_sustainability' => 'Innovation - Sustainability',
        'implementation_implementation' => 'Implementation - Implementation',
        'implementation_run' => 'Implementation - Run',
    ];

    public function responses()
    {
        return $this->hasMany(SelectionCriteriaQuestionResponse::class, 'question_id');
    }

    public function vendorProfileQuestion()
    {
        return $this->belongsTo(VendorProfileQuestion::class, 'vendor_profile_question_id');
    }

    public function practice(){
        return $this->belongsTo(Practice::class,'practice_id');
    }

    public function linkedQuestion(){
        return $this->belongsTo(SelectionCriteriaQuestion::class,'linked_question_id');
    }
}
