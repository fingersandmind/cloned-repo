<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProfileModel;
use App\PendingbtcRegister;
use App\User;

use Validator;
use Response;
use DB;
use Crypt;


class AjaxController extends Controller
{
    //

    public function validateSponsor(Request $request)
    {
   
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'sponsor' => 'exists:users,username|required',
        ]);
        // dd($request->all());
        
        if ($validator->fails()) {
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
        
        return response()->json(['valid' => false]);


    }


     public function bitaps(Request $request,$paymentid,$username)
    {
        $item = PendingbtcRegister::where('username',$username)->where('id',$paymentid)->first();

        
        if (is_null($item)) {
    		return response()->json(['valid' => false]);
    	}elseif($item->status == 'finished'){
            $user_id = User::where('username',$item->username)->value('id');
            return response()->json(['valid' => true,'status'=>$item->status,'id'=>Crypt::encrypt($user_id)]);
        }else{
             return response()->json(['valid' => true,'status'=>$item->status,'id'=>null]);
            
    	}
        
        return response()->json(['valid' => false]);


    }

    public function globalmap(Request $request){
        $user_info = ProfileModel::groupBy('country')->select('country', DB::raw('count("country") as total'))->get();
        $keyed = $user_info->mapWithKeys(function ($item) {
            return [$item['country'] => $item['total']];
        });
        $list = $keyed->all();
        return Response::json($list);
    }


}
