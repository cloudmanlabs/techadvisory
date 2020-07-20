<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property User $user
 * @property string $text
 * @property \Carbon\Carbon $created_at
 */
class SecurityLog extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function createLog(string $text)
    {
        (new self([
            'user_id' => optional(auth()->user())->id,
            'text' => $text,
        ]))->save();
    }
}
