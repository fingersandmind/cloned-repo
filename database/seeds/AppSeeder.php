<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         App\AppSettings::create([ 
           'company_name' => 'RAISERS',
           'company_address' => 'Mumbai',
           'email_address' => 'info@cloud.com',
           'logo' => 'logolight2.png',
           'logo_ico' => 'logolight2.png',
           'theme' => 'default',
          ]);
    }
}
