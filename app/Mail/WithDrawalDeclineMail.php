<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithDrawalDeclineMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $date)
    {
        $this->user = $user;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Estado de Solicitud Retiro en Zurviz')->view('mails.withdrawal-decline');
    }
}
