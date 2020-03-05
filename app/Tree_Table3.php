<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tree_Table3 extends Model
{
    
    protected $table = 'tree_table_3';

    protected $fillable = ['user_id', 'sponsor', 'placement_id', 'leg'];

      public static function getAvailableplacement($placement_id){

    	   if(SELF::where('user_id',$placement_id)->exists()){
    	   		return $placement_id ;
    	   }
    	   $sponsor = Tree_Table::where('user_id',$placement_id)->value('placement_id');
    	   return SELF::getAvailableplacement($sponsor) ;

    }

     public static function getPlacementId($placement_id)
    {
        $placement = SELF::whereIn('placement_id', $placement_id)->where("type", "=", "vaccant")->orderBy('id')->value('id');

        if ($placement) {
            return $placement;
        }

        $placement_id = SELF::whereIn('placement_id', $placement_id)->pluck('user_id');

        return SELF::getPlacementId($placement_id);

    }

    
    public static function createVaccant($placement_id,$vaccant_entries)
    {

        foreach ($vaccant_entries as $key => $pos) {
         
            SELF::create([
                'sponsor'      => 0,
                'user_id'      => '0',
                'placement_id' => $placement_id,
                'leg'          => $pos,
                'type'         => 'vaccant',
            ]); 
        }
         

    }

    public static function createOneVaccant($placement_id,$pos)
    {

        SELF::create([
            'sponsor'      => 0,
            'user_id'      => '0',
            'placement_id' => $placement_id,
            'leg'          => $pos,
            'type'         => 'vaccant',
        ]);  

    }
    

    public static function getDownlinesperlevel($placement, $level,$current_level = 1 )
    {
          $downlines = SELF::whereIn('placement_id',$placement)->where('type','<>','vaccant')->pluck('user_id') ;  

          if($current_level == $level){
             return SELF::whereIn('placement_id',$placement)->where('type','<>','vaccant')->count() ; 
          } 

          return SELF::getDownlinesperlevel($downlines,$level,++$current_level) ;


    }

     public static function getFatherID($user_id)
    {

        return SELF::where('user_id', $user_id)->value('placement_id');
    }
}
