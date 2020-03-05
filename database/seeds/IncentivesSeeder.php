<?php

use Illuminate\Database\Seeder;

class IncentivesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Incentives::create( [	
        				'package'=>1,
        				'level_1'=>null,
        				'level_2'=>null,
        				'level_3'=>null,
        				'level_4'=>null,
        				'level_5'=>null
        			]) ;
        \App\Incentives::create( [	
        				'package'=>2,
        				'level_1'=>null,
        				'level_2'=>'A brand new Laptop',
        				'level_3'=>null,
        				'level_4'=>'A brand New All-In-One Desktop at the completion of Level',
        				'level_5'=>'International Paid Trip at the completion of Level 5'
        			]) ;
        \App\Incentives::create( [	
        				'package'=>3,
        				'level_1'=>null,
        				'level_2'=>'A brand new Car',
        				'level_3'=>null,
        				'level_4'=>'International Investment and Loan Fund Membership Card',
        				'level_5'=>'Interest and collateral FREE Loan'
        			]) ;
        \App\Incentives::create( [	
        				'package'=>4,
        				'level_1'=>null,
        				'level_2'=>null,
        				'level_3'=>null,
        				'level_4'=>null,
        				'level_5'=>'A Brand New SUV (4 Wheel Drive ), Housing Fund $500,000.'
        			]) ;
        \App\Incentives::create( [	
        				'package'=>5,
        				'level_1'=>null,
        				'level_2'=>null,
        				'level_3'=>null,
        				'level_4'=>null,
        				'level_5'=>'Trustee membership Card,Monthly Residual Income for Life ($10,000)'
        			]) ;

          \App\Incentives::create( [    
                        'package'=>6,
                        'level_1'=>null,
                        'level_2'=>null,
                        'level_3'=>null,
                        'level_4'=>null,
                        'level_5'=>'Trustee membership Card,Monthly Residual Income for Life ($10,000)'
                    ]) ;
             \App\Incentives::create( [ 
                        'package'=>7,
                        'level_1'=>null,
                        'level_2'=>null,
                        'level_3'=>null,
                        'level_4'=>null,
                        'level_5'=>'Trustee membership Card,Monthly Residual Income for Life ($10,000)'
                    ]) ;
              \App\Incentives::create( [    
                        'package'=>8,
                        'level_1'=>null,
                        'level_2'=>null,
                        'level_3'=>null,
                        'level_4'=>null,
                        'level_5'=>'Trustee membership Card,Monthly Residual Income for Life ($10,000)'
                    ]) ;
               \App\Incentives::create( [   
                        'package'=>9,
                        'level_1'=>null,
                        'level_2'=>null,
                        'level_3'=>null,
                        'level_4'=>null,
                        'level_5'=>'Trustee membership Card,Monthly Residual Income for Life ($10,000)'
                    ]) ;

    }
}
