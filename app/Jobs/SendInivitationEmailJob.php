<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\MeetingInvitationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInivitationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $link;
    protected $email;
    protected $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $link, $email, $code)
    {
        $this->name = $name;
        $this->link = $link;
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new MeetingInvitationMail($this->name, $this->link, $this->code));
    }
}
