<?php

namespace App\Jobs;

use App\Mail\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $name_send;
    protected $message_n;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $message_n, $email, $name_send)
    {
        $this->name = $name;
        $this->message_n = $message_n;
        $this->email = $email;
        $this->name_send = $name_send;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->email);
        Mail::to($this->email)->send(new SendMessage($this->name, $this->message_n, $this->name_send));
    }
}
