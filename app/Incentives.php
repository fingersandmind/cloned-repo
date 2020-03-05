<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;


class Incentives extends Model
{
    


    protected $table = 'incentives';

    protected $fillable = ['package','level_1','level_2','level_3','level_4','level_5'] ;



     public static function distributeLevelIncentives($user_id,$level,$tree=1){

           
            $incentive = SELF::where('id',$tree)->value('level_'.$level) ; 
            if($incentive != null){

             $commision = DB::table('incentives_list')->insert([
                'user_id'        => $user_id,
                'stage'        => $tree,
                'level'   => $level,
                'incentive'  => $incentive, 
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
          ]); 
            }

            return $incentive;

             
   }


}
