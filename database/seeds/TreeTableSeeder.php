<?php

use Illuminate\Database\Seeder;

class TreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {


        // bronze table 
       \App\Tree_Table::create(['sponsor'        => '0','user_id'        => '1','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '3','type'   => 'vaccant']); 

       
       \App\Tree_Table2::create(['sponsor'        => '0','user_id'        => '1','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '3','type'   => 'vaccant']);  
       
       \App\Tree_Table3::create(['sponsor'        => '0','user_id'        => '1','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '3','type'   => 'vaccant']);  

       
       
       \App\Tree_Table4::create(['sponsor'        => '0','user_id'        => '1','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '3','type'   => 'vaccant']);  

       \App\Tree_Table5::create(['sponsor'        => '0','user_id'        => '1','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table5::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table5::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table5::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 1,'leg'   => '3','type'   => 'vaccant']);



         // premium plan  
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '2','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '3','type'   => 'vaccant']); 

       
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '2','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table2::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '3','type'   => 'vaccant']);  
       
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '2','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table3::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '3','type'   => 'vaccant']);  

       
       
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '2','placement_id'   => 0,'leg'   => '1','type'   => 'yes']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '1','type'   => 'vaccant']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '2','type'   => 'vaccant']); 
       \App\Tree_Table4::create(['sponsor'        => 0,'user_id'        => '0','placement_id'   => 2,'leg'   => '3','type'   => 'vaccant']);  
 


    }
}
