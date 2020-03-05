<?php

use Illuminate\Database\Seeder;

class welcomeemailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         DB::table('welcomeemail')->insert([
        	 
        	  'to_email' => 'info@cloudmlmsoftware.com', 
        	  'subject' => 'Welcome Email', 
        	  'body' => 'Welcome Email Message',
              ]);
    }
}
