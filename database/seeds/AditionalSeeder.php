<?php

use App\PaymentGateway;
use App\Plan;
use App\SocialNetwork;
use App\SubTopic;
use App\Thematic;
use Illuminate\Database\Seeder;

class AditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /*Thematic::create([
           'name' => 'Medicina',
           'state' => 1
       ]);

        Thematic::create([
            'name' => 'Educación',
            'state' => 1
        ]);

        Thematic::create([
            'name' => 'Derecho',
            'state' => 1
        ]);

        Thematic::create([
            'name' => 'Fitness',
            'state' => 1
        ]);

        SubTopic::create([
           'name' => 'Psicología',
           'thematic_id' => 1,
           'state' => 1
        ]);

        SubTopic::create([
            'name' => 'Pediatría',
            'thematic_id' => 1,
            'state' => 1
        ]);

        SubTopic::create([
            'name' => 'General',
            'thematic_id' => 1,
            'state' => 1
        ]);*/

        SocialNetwork::create([
            'name' => 'Facebook',
            'state' => 1
        ]);

        SocialNetwork::create([
            'name' => 'Twitter',
            'state' => 1
        ]);

        SocialNetwork::create([
            'name' => 'Instragram',
            'state' => 1
        ]);

        SocialNetwork::create([
            'name' => 'Linkenid',
            'state' => 1
        ]);

        PaymentGateway::create([
            'name' => 'Tarjeta de Crédito',
            'state' => 1
        ]);

        PaymentGateway::create([
            'name' => 'Paypal',
            'state' => 1
        ]);

        Plan::create([
            'name' => 'Plan Premium Mensual',
            'price' => 510.00,
            'description' => 'Disfruta por 1 mese',
            'validity_day' => 30,
            'state' => 1,
            'user_created' => 1,
            'user_updated' => 1
        ]);

        Plan::create([
            'name' => 'Plan Premium Anual',
            'price' => 4900,
            'description' => 'Disfruta por 1 año',
            'validity_day' => 365,
            'state' => 1,
            'user_created' => 1,
            'user_updated' => 1
        ]);



    }
}
