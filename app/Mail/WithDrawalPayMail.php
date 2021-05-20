<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithDrawalPayMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $user;
    public $total;
    public $operation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $total, $operation)
    {
        $this->user = $user;
        $this->total = $total;
        $this->operation = $operation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Estado de Solicitud Retiro en Zurviz')->view('mails.withdrawal-pay');
    }
}
