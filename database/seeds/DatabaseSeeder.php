<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AditionalSeeder::class);
        $this->call(DealsTableSeeder::class);
        $this->call(informationSeeder::class);
        $this->call(SiteSocialSeeder::class);
        $this->call(PricesAdvertisementsSeeder::class);
        $this->call(WithdrawalPoliciesSeeder::class);
        $this->call(PathSeeder::class);
        $this->call(AdvertisementsSeeders::class);
        $this->call(ThematicSubSeeder::class);

    }
}
