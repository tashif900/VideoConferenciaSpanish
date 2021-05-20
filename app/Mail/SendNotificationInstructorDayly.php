<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotificationInstructorDayly extends Mailable implements ShouldQueue
{ 
    use Queueable, SerializesModels;

    public $type;
    public $element;
    public $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($element, $type, $participant)
    {
        $this->element = $element;
        $this->type = $type;
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 1) {
            $subject = 'Recordatorio de Inicio de Clase ' . $this->element->name . ' en Zurviz. Inicia en un día.';
        } else if ($this->type == 2) {
            $subject = 'Recordatorio de Inicio de Sesión ' . $this->element->name . ' en Zurviz. Inicia en un día.';
        } else {
            $subject = 'Recordatorio de Inicio de Sesión ' . $this->element->name . ' en Zurviz. Inicia en un día.';
        }

        return $this->subject($subject)->view('mails.notification-participants-dayly-mail');
    }
}
