<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $response
 * @property bool $shouldShow Yes, this is actually $validated, but time constraints :) I hate it too
 *
 * @property \App\VendorProfileQuestion $originalQuestion
 * @property \App\User $vendor
 */
class VendorProfileQuestionResponse extends Model
{
    public $guarded = [];

    public $casts = [
        'shouldShow' => 'boolean'
    ];

    public function originalQuestion()
    {
        return $this->belongsTo(VendorProfileQuestion::class, 'question_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
