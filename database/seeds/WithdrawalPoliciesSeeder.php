<?php

use App\WithdrawalPolicy;
use Illuminate\Database\Seeder;

class WithdrawalPoliciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WithdrawalPolicy::create([
            'start_day' => 'Lunes',
            'amount_max' => 1000,
            'state' => 1,
            'user_create' => 1,
            'user_update' => 1,
        ]);
    }
}
