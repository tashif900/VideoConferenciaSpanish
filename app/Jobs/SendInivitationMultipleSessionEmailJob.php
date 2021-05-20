<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\MultipleMeetingInvitationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInivitationMultipleSessionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $link;
    protected $email;
    protected $code;
    protected  $linkinvitacion;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $link, $email, $code, $linkinvitacion)
    {
        $this->name = $name;
        $this->link = $link;
        $this->email = $email;
        $this->code = $code;
        $this->linkinvitacion = $linkinvitacion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new MultipleMeetingInvitationMail($this->name, $this->link, $this->code, $this->linkinvitacion));
    }
}
