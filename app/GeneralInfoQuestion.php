<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $response
 *
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 * @property boolean $required
 *
 * @property string $options
 */
class GeneralInfoQuestion extends Model
{
    public $guarded = [];
    public $fieldNames = [
        'label'
    ];

    const questionTypes = ['text', 'textarea', 'selectSingle', 'selectMultiple'];
}
