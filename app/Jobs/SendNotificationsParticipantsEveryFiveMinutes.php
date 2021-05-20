<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\MailNotificationParticipantsEveryFiveMinutes;

class SendNotificationsParticipantsEveryFiveMinutes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $element;
    public $participant;
    public $type;
    public $minute;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($element, $participant, $type, $minute)
    {
        $this->element = $element;
        $this->participant = $participant;
        $this->type = $type;
        $this->minute = $minute;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->participant->email)->send(new MailNotificationParticipantsEveryFiveMinutes($this->element, $this->type, $this->participant, $this->minute));
    }
}
