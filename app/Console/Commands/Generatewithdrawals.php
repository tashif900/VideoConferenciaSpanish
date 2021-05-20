<?php

namespace App\Console\Commands;

use App\InstructorMovement;
use App\User;
use App\WithdrawalPolicy;
use App\WithdrawalRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Generatewithdrawals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:withdrawal_requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera retiros para los usuarios';

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
        $users = User::role('Profesor')->where('state', 1)->where('enable_withdrawal',1)->get();
        $policie = WithdrawalPolicy::all()->last();
        //dd($users);
        foreach ($users as $user){
            $movements = InstructorMovement::where('user_id', $user->id)->where('state', 1)->get();
            $amount_week =0.00;
            //dd($movements);
            foreach ($movements as $movement){
                $amount = (float) $movement->amount * (float) $movement->platform_percentage;
                $amount_week = $amount_week + $amount;
            }
            //dd($amount_week);
            if ($amount_week >= $policie->amount_max){
                $withdrawal_requests = new  WithdrawalRequest();

                $amount_week =0.00;
                foreach ($movements as $movement){
                    $amount = (float) $movement->amount * (float) $movement->platform_percentage;
                    $amount_week = $amount_week + $amount;
                    $mov = InstructorMovement::find($movement->id);
                    $mov->state =3; //Pendiente
                    $mov->save();
                }

                $withdrawal_requests->request_date = Carbon::now();
                $withdrawal_requests->user_id = $user->id;
                $withdrawal_requests->amount = $amount_week;
                $withdrawal_requests->comment = "Solicitud de pago generada automáticamente";
                $withdrawal_requests->state = 1;
                $withdrawal_requests->save();
            }
        }

        return 'Realizado correctamente';
    }


}
