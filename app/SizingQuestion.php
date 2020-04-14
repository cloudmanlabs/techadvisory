<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 *
 * @property string $label
 * @property boolean $required
 */
class SizingQuestion extends Model
{
    public $guarded = [];


    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }






    const questionTypes = ['text', 'textarea', 'selectSingle', 'selectMultiple', 'date'];
    const presetOptions = ['countries', 'transportModes', 'transportFlows', 'transportTypes', 'custom'];

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
            case 'custom':
            default:
                return explode(',', $this->options);
        }
    }
}
