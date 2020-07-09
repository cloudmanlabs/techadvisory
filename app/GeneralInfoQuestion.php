<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 * @property boolean $required
 * @property string $page
 *
 * @property string $presetOption
 * @property string $options
 *
 * @property bool $onlyView
 *
 * @property \Illuminate\Support\Collection $responses
 * @property ClientProfileQuestion|null $clientProfileQuestion
 * @property Practice|null $practice
 */
class GeneralInfoQuestion extends Question
{
    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public $casts = [
        'onlyView' => 'boolean'
    ];

    const pagesSelect = [
        'project_info' => 'Project Info',
        'practice' => 'Practice',
        'scope' => 'Scope',
        'timeline' => 'Timeline',
    ];

    public function responses()
    {
        return $this->hasMany(GeneralInfoQuestionResponse::class, 'question_id');
    }

    public function clientProfileQuestion()
    {
        return $this->belongsTo(ClientProfileQuestion::class, 'client_profile_question_id');
    }
}
