<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

 use App\PostbackLog ;
 use App\PendingbtcRegister ;
use Artisan ;


class CronController extends Controller
{
        
    public function bitapspostback(Request $request)
    {
        try {
              PostbackLog::create(['response'=>json_encode($request->all())]) ;
          

             if($request->confirmations >=3){

                  $item = PendingbtcRegister::where('payment_code',$request->code)->first();

                  if($item->status == 'new'){

                        $item->status = 'complete';

                        $item->payment_response_data = json_encode($request->all());
                        $item->save() ;  
                  }


             }

        } catch (Exception $e) {
           
        }
    }

    public function ipaysuccess(Request $request,$id,$username)
    {
        try {
              PostbackLog::create(['response'=>json_encode($request->all())]) ;

              $setting = PendingbtcRegister::find($id);
              $status = file_get_contents('https://community.ipaygh.com/v1/gateway/json_status_chk?invoice_id='.$username.'&merchant_key=tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f');

              $status =json_decode($status,true);
 

               return view('auth.ipay',compact('payment_details','pacakge_amount','setting'));  
             

        } catch (Exception $e) {
           
        }
    }

    public function ipaycanceled(Request $request,$id,$username)
    {
        try {
              PostbackLog::create(['response'=>json_encode($request->all())]) ;

              $setting = PendingbtcRegister::find($id);
              $status = file_get_contents('https://community.ipaygh.com/v1/gateway/json_status_chk?invoice_id='.$username.'&merchant_key=tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f');

              $status =json_decode($status,true); 


               return view('auth.ipay',compact('payment_details','pacakge_amount','setting'));  
             

        } catch (Exception $e) {
           
        }
    }

    public function ipayipn(Request $request)
    {

        try {
          $status = file_get_contents('https://community.ipaygh.com/v1/gateway/json_status_chk?invoice_id='.$request->invoice_id.'&merchant_key=tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f');

          PostbackLog::create(['response'=>$status]) ;

          $result = json_decode($status,true);

              $item = PendingbtcRegister::where('invoice_id',$request->invoice_id)->first();


          if($result[$request->invoice_id]['status'] =='paid' && $item->status = 'new'){
              
              $item->status = 'complete';
              $item->payment_response_data = $status;
              $item->save() ;  
          }else{
              $item->status = $result[$request->invoice_id]['status'];
              $item->payment_response_data = json_encode($request->all());
              $item->save() ;
          }
              

             

        } catch (Exception $e) {
           
        }
    }

 


}

