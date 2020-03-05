<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transactions extends Model
{
     
    use SoftDeletes;

    protected $table = 'commission';

    protected $fillable = ['user_id', 'from_id','total_amount','tds','service_charge','payable_amount','payment_type','payment_status'];


    public static function sponsorcommission($sponsor_id,$from_id,$package){

         $settings = Settings::getSettings(); 


 
         $sponsor_commisions = Packages::find($package)->amount *0.25 ; 

         $tds = $sponsor_commisions * $settings[0]->tds / 100;
         /**
         * calcuate service charge
         * @var [type]
         */
         $service_charge = $sponsor_commisions * $settings[0]->service_charge / 100;
         /**
         * Calculates payable amount
         * @var [type]
         */
         $payable_amount = $sponsor_commisions - $tds - $service_charge;
         /**
         * Creates entry for user in commission table and set payment status to yes
         * @var [type]
         */
         $commision = SELF::create([
                'user_id'        => $sponsor_id,
                'from_id'        => $from_id,
                'total_amount'   => $sponsor_commisions,
                'tds'            => $tds,
                'service_charge' => $service_charge,
                'payable_amount' => $payable_amount,
                'payment_type'   => 'referral_bonus',
                'payment_status' => 'Yes',
          ]);
          /**
          * updates the userbalance
          */
          User::upadteUserBalance($sponsor_id, $payable_amount);




    }


    
   public static function distributeLevelbonus($user_id,$level,$tree=1){

            $settings = Settings::getSettings(); 

            $amount = Packages::where('id',$tree)->value('level_'.$level) ;
            $package = Packages::where('id',$tree)->value('package') ;
            $tds = $amount * $settings[0]->tds / 100;
            $service_charge = $amount * $settings[0]->service_charge / 100;
            $payable_amount = $amount - $tds - $service_charge;

             $commision = SELF::create([
                'user_id'        => $user_id,
                'from_id'        => $user_id,
                'total_amount'   => $amount,
                'tds'            => $tds,
                'service_charge' => $service_charge,
                'payable_amount' => $payable_amount,
                'payment_type'   => 'level_'.$level."_bonus : " .$package,
                'payment_status' => 'Yes',
          ]); 

             User::upadteUserBalance($user_id, $payable_amount);
   }


  

      public static function distributeBoardbonus($user_id,$tree=1){

            $settings = Settings::getSettings(); 
            $amount = Packages::where('id',$tree)->value('board') ;
            $package = Packages::where('id',$tree)->value('package') ;
            $tds = $amount * $settings[0]->tds / 100;
            $service_charge = $amount * $settings[0]->service_charge / 100;
            $payable_amount = $amount - $tds - $service_charge;

             $commision = SELF::create([
                'user_id'        => $user_id,
                'from_id'        => $user_id,
                'total_amount'   => $amount,
                'tds'            => $tds,
                'service_charge' => $service_charge,
                'payable_amount' => $payable_amount,
                'payment_type'   => 'board_bonus : ' .$package,
                'payment_status' => 'Yes',
          ]); 

             User::upadteUserBalance($user_id, $payable_amount);
   }


   public static function getUplineId($user_id){
         return DB::table('tree_table')->where('user_id', $user_id)->pluck('placement_id');
   }

   
   public static function updateUserBalance($user_id, $amount){

      return    Balance::where('user_id', $user_id)->increment('balance',$amount);

   }

  
 

}
