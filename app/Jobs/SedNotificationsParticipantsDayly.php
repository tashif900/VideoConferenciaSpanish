<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SedNotificationsParticipantsDayly implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $element, $participant, $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($element, $participant, $type)
    {
        $this->element = $element;
        $this->participant = $participant;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->participant->email)->send(new MailNotificationParticipantsDayli($this->element, $this->type, $this->participant));
    }
}
