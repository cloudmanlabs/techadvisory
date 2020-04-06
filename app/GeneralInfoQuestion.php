<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $question
 * @property string $type
 */
class GeneralInfoQuestion extends Model
{
    public $guarded = [];

    const questionTypes = ['text'];
}
