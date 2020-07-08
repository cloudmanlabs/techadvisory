<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 *
 * @property string $presetOption
 * @property string $options
 *
 * @property string $page
 *
 * @property \Illuminate\Support\Collection $dependentSelectionCriteriaQuestions
 */
class VendorProfileQuestion extends Question
{
    public function dependentSelectionCriteriaQuestions()
    {
        return $this->hasMany(SelectionCriteriaQuestion::class, 'vendor_profile_question_id');
    }
}
