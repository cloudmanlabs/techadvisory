<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public static function createLog(string $text, string $context = null, $data = null)
    {
        $log = '';

        if ($context) {
            $log .= '['.$context.'] ';
        }

        $log .= $text;

        if ($data) {
            $log .= ' '.serialize($data);
        }

        (new self([
            'user_id' => optional(auth()->user())->id,
            'credential_id' => session('credential_id'),
            'text' => $log,
        ]))->save();
    }
}
