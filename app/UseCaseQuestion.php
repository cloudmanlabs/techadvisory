<?php


namespace App;

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
 * @property \Illuminate\Support\Collection $useCaseResponses
 * @property \Illuminate\Support\Collection $useCaseTemplateResponses
 * @property Practice|null $practice
 */
class UseCaseQuestion extends Question
{
    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    const selectTypesEdit = [
        'text' => 'Text',
        'textarea' => 'Text Area',
        'selectSingle' => 'Select',
        'selectMultiple' => 'Select multiple',
        'date' => 'Date',
        'number' => 'Number',
        'email' => 'Email',
        'percentage' => 'Percentage',
        'file' => 'File',
    ];

//    public function responses()
//    {
//        return $this->hasMany(useCaseQuestionResponse::class, 'use_case_questions_id');
//    }

    public function useCaseResponses()
    {
        return $this->hasMany(useCaseQuestionResponse::class, 'use_case_questions_id');
    }

    public function useCaseTemplateResponses()
    {
        return $this->hasMany(useCaseTemplateQuestionResponse::class, 'use_case_questions_id');
    }
}
