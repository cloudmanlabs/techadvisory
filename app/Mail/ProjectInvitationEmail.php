<?php

namespace App\Mail;

use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User $vendor */
    protected $vendor;
    /** @var Project $project */
    protected $project;
    /** @var string $text */
    protected $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $vendor, Project $project, string $text)
    {
        // Not really needed atm
        $this->vendor = $vendor;
        $this->project = $project;

        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@mg.techadvisory.ideafoster.com')->view('emails.reinvitationEmail', [
            'text' => $this->text
        ]);
    }
}
