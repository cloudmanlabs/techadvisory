<?php

namespace App;

use App\Mail\CredentialResetPasswordMail;
use App\Mail\NewCredentialMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * @property string $name
 * @property string $email
 * @property string|null $password
 *
 * @property string|null $passwordChangeToken
 *
 * @property boolean $hidden
 *
 * @property User $user
 * @property integer $user_id
 */
class UserCredential extends Model
{
    public $guarded = [];

    protected $casts = [
        'hidden' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visibleProjects()
    {
        return $this->hasMany(VisibleProject::class, 'user_credential_id');
    }

    /**
     * Sets a new token and sends an email
     *
     * @return void
     */
    public function sendSignUpEmail()
    {
        $this->setPasswordChangeToken();
        Mail::to($this->email)
            ->bcc($this->user()->accenture_cc_email)
            ->send(new NewCredentialMail($this));
    }

    /**
     * Sets a new token and sends an email
     *
     * @return void
     */
    public function sendPasswordResetEmail()
    {
        $this->setPasswordChangeToken();
        Mail::to($this->email)
            ->bcc($this->user()->accenture_cc_email)
            ->send(new CredentialResetPasswordMail($this));
    }

    /**
     * Returns the link to reset the password
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function passwordChangeLink()
    {
        return !empty($this->passwordChangeToken) ? url("/changePassword/{$this->passwordChangeToken}") : '';
    }

    /**
     * Sets a new password change token
     *
     * @return void
     */
    public function setPasswordChangeToken()
    {
        do {
            $token = Str::uuid();
        } while (UserCredential::where("passwordChangeToken", $token)->first() != null);

        $this->passwordChangeToken = $token;
        $this->save();
    }
}
