<?php

namespace App\Mail;

use App\UserCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CredentialResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var UserCredential $credential */
    private $credential;

    /** @var bool $isVendor */
    private $isVendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserCredential $credential)
    {
        $this->credential = $credential;
        $this->isVendor = optional($credential->user)->isVendor() ?? false;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = $this->isVendor ? nova_get_setting('email_credentialResetPassword_vendor') : nova_get_setting('email_credentialResetPassword_client');
        $text = $text ?? 'Welcome to TechAdvisory platform!';

        $subject = $this->isVendor ? nova_get_setting('email_subject_credentialResetPassword_vendor') : nova_get_setting('email_subject_credentialResetPassword_client');
        $subject = $subject ?? 'TechAdvisory: Password reset';

        return $this->view('emails.newCredentialMail', [
            'text' => $text,
            'link' => $this->credential->passwordChangeLink(),
        ])
                ->subject($subject);
    }
}
