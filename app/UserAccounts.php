<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAccounts extends Model
{
    

    use SoftDeletes;


    protected $table = 'user_accounts';
    

    protected  $fillable =['user_id','matrix'] ;

     public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function addnewaccount($data){
    		
    		$bronze_account = UserAccounts::where('user_id',$value->id)->first()->id ;
    		$placement_id = SELF::getAvailablePlacement($bronze_account);

    		$account_id =UserAccounts::create([
    			'user_id' => $value->id,
    			'matrix'  => 6,           
    		]); 
    		$placement_id = UserAccounts::where('user_id',$placement_id)->where('matrix',6)->first()->id ;
            $placement = Tree_Table::getPlacementId([$placement_id]);
            $tree          = Tree_Table::find($placement);
            $tree->user_id = $account_id->id;
            $tree->sponsor = $sponsor_id;
            $tree->type    = 'yes';
            $tree->save();

             $balanceupdate = SELF::insertToBalance($account_id->id);

             return $account_id ;

    }


    public function getAvailablePlacement($user_id){


    }

}
