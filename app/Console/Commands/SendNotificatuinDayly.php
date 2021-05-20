<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationsController;

class SendNotificatuinDayly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:dayly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia las notificaciones de sesiones, clases y cursos un dia antes de empezar';

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
        return NotificationsController::participantsDayly();
    }
}
