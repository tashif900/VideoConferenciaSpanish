<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotificationDayly extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $element, $participant, $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->element = $element;
        $this->participant = $participant;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.notification-participants-dayly-mail');
    }
}
