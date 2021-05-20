<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MultipleMeetingInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $link;
    public $code;
    public $link_invitacion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $link, $code, $link_invitacion)
    {
        $this->name = $name;
        $this->link = $link;
        $this->code = $code;
        $this->link_invitacion = $link_invitacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitacion para participar en un meeting')->view('meetings.multiple-invitations-mail');
    }
}
