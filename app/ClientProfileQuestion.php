<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProfileQuestion extends Model
{
    public $guarded = [];

    const questionTypes = ['text', 'textarea', 'selectSingle', 'selectMultiple', 'date'];
    const presetOptions = [
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
            case 'countries':
                // Countries are dealt by through newProjectSetUp
                throw new Exception('This question has Countries as a Preset. You shouldn\'t be calling optionList on it');

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
            case 'custom':
            default:
                return explode(',', $this->options);
        }
    }
}
