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
 * @property \Illuminate\Support\Collection $responses
 */
class UseCaseQuestion extends Question
{
    public $guarded = [];

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
}
