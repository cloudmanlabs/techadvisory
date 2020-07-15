<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 *
 * @property string $label
 * @property string $placeholder
 *
 * @property string $presetOption
 * @property string $options
 *
 * @property bool $required
 *
 * @property Practice|null $practice
 */
class VendorSolutionQuestion extends Question
{
    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }
}
