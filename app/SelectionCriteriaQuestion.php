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

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }

    public function linkedQuestion()
    {
        return $this->belongsTo(SelectionCriteriaQuestion::class, 'linked_question_id');
    }

    /**
     *  METHOD FOR NOVA
     * Each SelectionCriteriaQuestion has a group of SelectionCriteriaQuestion that can be linked to,
     *  depending to their page and practice (SC Capability) chosen before.
     * @return array linked Question to select (only for backoffice purposes)
     */
    public function getPossibleLinkedQuestionsFiltered()
    {
        $result = SelectionCriteriaQuestion::where('id', '!=', $this->id)
        ->whereNull('linked_question_id');
        if ($this->page != null) {
            // in fact, page is a required attribute.
            $result = $result->where('page', '=', $this->page);

            if ($this->practice != null) {
                // practice filter.
                $result = $result->where('practice_id', '=', $this->practice->id);

            } else {
                // no practice filter.
                $result = $result->whereNull('practice_id');
            }
        }
        // [question id] => question label
        $questionsStructureForNova = [];
        foreach ($result->get() as $question) {
            $questionsStructureForNova[$question->id] = $question->label;
        }
        return $questionsStructureForNova;
    }
}
