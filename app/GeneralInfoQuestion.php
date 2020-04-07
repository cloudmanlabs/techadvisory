<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property string $response
 *
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 * @property boolean $required
 *
 * @property string $presetOption
 * @property string $options
 */
class GeneralInfoQuestion extends Model
{
    public $guarded = [];
    public $fieldNames = [
        'label'
    ];

    const questionTypes = ['text', 'textarea', 'selectSingle', 'selectMultiple'];
    const presetOptions = ['countries', 'transportModes', 'transportFlows', 'transportTypes', 'custom'];


    public function optionList()
    {
        switch($this->presetOption){
            case 'custom':
                return explode(',', $this->options);
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
        }
    }
}
