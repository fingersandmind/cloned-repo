<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App\Packages::create([
          'package'=>'Agent',
          'amount'=>'16',
          'level_1'=>'5',
          'level_2'=>'13',
          'level_3'=>'35',
          'level_4'=>'0',
          'level_5'=>'0',
          'board'=>'62'        
        ]);
       App\Packages::create([
          'package'=>'Sotkist',
          'amount'=>'0',
           'level_1'=>'91',
          'level_2'=>'233',
          'level_3'=>'500',
          'level_4'=>'1400',
          'level_5'=>'3000',
          'board'=>'7776',
         
        ]);
      App\Packages::create([
          'package'=>'Master',
          'amount'=>'0',
           'level_1'=>'4000',
          'level_2'=>'6000',
          'level_3'=>'20000',
          'level_4'=>'50000',
          'level_5'=>'120000',
          'board'=>'100000',
          
        ]);

        
    }
}
