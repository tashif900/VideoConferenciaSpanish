<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $user;
    public $info;
    public $url_app;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $user, $info)
    {
        $this->url_app = "https://www.zurviz.com";
        if (env('APP_URL')!=null && env('APP_URL')!="")
            $this->url_app = env('APP_URL');

        $this->type = $type;
        $this->user = $user;
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmación de Compra en Zurviz')->view('mails.confirmation-purchase');
    }
}
