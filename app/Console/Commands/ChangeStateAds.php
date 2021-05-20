<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationsController;

class ChangeStateAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el vencimiento de los anuncios';

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
        return NotificationsController::changeStatetoAdvertisement();
    }
}
