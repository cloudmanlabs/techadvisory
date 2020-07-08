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
 * @property \Illuminate\Support\Collection $dependentGeneralInfoQuestions
 */
class ClientProfileQuestion extends Question
{
    public function dependentGeneralInfoQuestions()
    {
        return $this->hasMany(GeneralInfoQuestion::class, 'client_profile_question_id');
    }
}
