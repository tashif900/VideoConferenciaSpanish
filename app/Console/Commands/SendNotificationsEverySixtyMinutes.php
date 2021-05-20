<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendNotificationsEverySixtyMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:thirtyminute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia las notificaciones de sesiones y clases 30 minutos antes de empezar.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return NotificationsController::participantsEveryThirtyMinutes();
    }
}
