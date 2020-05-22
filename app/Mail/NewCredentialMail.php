<?php

namespace App\Mail;

use App\UserCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCredentialMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var UserCredential $credential */
    private $credential;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserCredential $credential)
    {
        $this->credential = $credential;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newCredentialMail', [
            'text' => 'Welcome to TechAdvisory platform!',
            'link' => $this->credential->passwordChangeLink(),
        ])
                ->subject('Welcome to TechAdvisory platform!');
    }
}
