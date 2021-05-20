<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $message_n;
    public $name_send;

    public function __construct($name, $message_n, $name_send)
    {
        $this->name = $name;
        $this->message_n = $message_n;
        $this->name_send = $name_send;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ha recibido un nuevo mensaje')
            ->view('mails.notification-message');
    }
}
