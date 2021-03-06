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
 */
class SizingQuestion extends Question
{
    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }
}
