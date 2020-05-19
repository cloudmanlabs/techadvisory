<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
