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
 *
 * @property string $presetOption
 * @property string $options
 */
class GeneralInfoQuestion extends Question
{
    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }
}
