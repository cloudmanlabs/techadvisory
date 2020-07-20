<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $presetOption
 * @property string $options
 */
abstract class Question extends Model
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
    ];

    const selectTypesDisplay = [
        'text' => 'Text',
        'textarea' => 'Text Area',
        'selectSingle' => 'Select',
        'selectMultiple' => 'Select multiple',
        'date' => 'Date',
        'number' => 'Number',
        'email' => 'Email',
        'percentage' => 'Percentage',
        'file' => 'File',
        'special' => 'Special'
    ];

    const questionTypes = ['text', 'textarea', 'selectSingle', 'selectMultiple', 'date', 'number', 'email'];
    const presetOptions = [
        'practices',
        'countries',
        'transportModes',
        'transportFlows',
        'transportTypes',
        'industryExperience',
        'regions',
        'custom'
    ];

    public function optionList()
    {
        switch ($this->presetOption) {
            case 'practices':
                return Practice::all()->pluck('name')->toArray();
            case 'countries':
                // Countries are dealt specially by the view
                throw new \Exception('This question has Countries as a Preset. You shouldn\'t be calling optionList on it');

            case 'transportModes':
                return config('arrays.transportModes');
            case 'transportFlows':
                return config('arrays.transportFlows');
            case 'transportTypes':
                return config('arrays.transportTypes');
            case 'currencies':
                return config('arrays.currencies');
            case 'projectTypes':
                return config('arrays.projectTypes');
            case 'industryExperience':
                return config('arrays.industryExperience');
            case 'regions':
                return config('arrays.regions');
            case 'digitalEnablers':
                return config('arrays.digitalEnablers');
            case 'custom':
            default:
                return array_map(function($element){
                    return trim($element);
                }, explode(',', $this->options));
        }
    }
}
