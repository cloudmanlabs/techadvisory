<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $response
 *
 * @property \App\ClientProfileQuestion $originalQuestion
 * @property \App\User $vendor
 */
class ClientProfileQuestionResponse extends Model
{
    public $guarded = [];


    public function originalQuestion()
    {
        return $this->belongsTo(ClientProfileQuestion::class, 'question_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
