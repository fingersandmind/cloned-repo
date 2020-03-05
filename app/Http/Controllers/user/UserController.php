<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Packages;
use App\PendingbtcRegister;
use DB;
use Srmklive\PayPal\Services\ExpressCheckout;


use App\Http\Controllers\user\UserAdminController;

class UserController extends UserAdminController
{

        protected static  $provider ;



     public function __construct()
    {
     
        self::$provider = new ExpressCheckout;    
    }


    
     public function suggestlist(Request $request){
          if($request->input != '/'  &&  $request->input != '.')
                    $users['results'] = User::join('sponsortree','sponsortree.user_id','=','users.id')->where('sponsortree.sponsor','=',Auth::user()->id)->where('username','like',"%".trim($request->input)."%")->select('users.id','username as value','email as info')->get();
           else   
                    $users['results'] = User::join('sponsortree','sponsortree.user_id','=','users.id')->where('sponsortree.sponsor','=',Auth::user()->id)->select('users.id','username as value','email as info')->get();

          echo json_encode($users);

     }


     public function incentivelist(){

        $title     = 'Incentives';
        $sub_title = 'Incentives';
        $base      = 'Incentives';
        $method    = 'Incentives';


        $incentives=DB::table('incentives_list')->join('packages','packages.id','=','incentives_list.stage')->where('user_id',Auth::user()->default_account)->get();

 
        return view('app.user.users.incentivelist', compact('title', 'incentives', 'sub_title', 'base', 'method'));
        

     }

     public function joinvip(){ 

     	$title     = 'Join Elite';
        $sub_title = 'Join Elite';
        $base      = 'Join Elite';
        $method    = 'Join Elite';

        $matrix_fee = Packages::find(6)->amount ;

        return view('app.user.users.joinvip',compact('title','countries','user','sub_title','base','method','matrix_fee'));
     	

     }


    public function upgradeaccount(Request $request){

          

                  $invoice_id= uniqid();

                  $upgrade_fee = Packages::find(6)->amount ;

               
                if($request->payment == 'ipaygh'){

                    $conversion = $this->url_get_contents('https://dev.kwayisi.org/apis/forex/usd/ghs',false);

                    $package_amount = $upgrade_fee * $conversion->rate; 

                    $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->id,
                                        'sponsor'=>'NA',
                                        'matrix'=>6,
                                        'amount_usd'=>$upgrade_fee,
                                        'amount_btc'=>$package_amount,
                                        'payment_method'=>'ipaygh',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>'ipay-upgrade-'.$invoice_id,
                                        'invoice'=>'ipay-upgrade-'.$invoice_id,
                                        'address'=>'ipay-upgrade-'.$invoice_id,
                                        'payment_data'=>json_encode([]),
                                        'event'=>'account',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 

 
                        echo '<form id="ipaygh" method=POST action="https://community.ipaygh.com/gateway">
                            <input type=hidden name=merchant_key value="tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f" />
                            <input type=hidden name=invoice_id value="'.$invoice_id.'" />
                            <input type=hidden name=success_url value="'.url('user/upgradenotify/success/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=cancelled_url value="'.url('user/upgradenotify/canceled/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=deferred_url value="'.url('user/upgradenotify/success/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=ipn_url value="'.url('paymentnotify/ipn').'" />
                            <input type=hidden name=currency value="GHS" />
                            <input type=hidden name=total value="'.$package_amount.'" /> 
                        </form>';

                    echo '  <script type="text/javascript">';
                    echo "  document.forms['ipaygh'].submit()  ";   
                    echo '  </script>'; 

                    die();

                }elseif ($request->payment =='bitcoin') {                   

                      
                    $url ='https://api.bitaps.com/btc/v1//create/payment/address' ;
                    $payment_details = $this->url_get_contents($url,[
                                                    'forwarding_address'=>'1CPKaZa9q19vu3ctMGqvbuP6Cfrto9G8G9',
                                                    'callback_link'=>url('bitaps/paymentnotify'),
                                                    'confirmations'=>3
                                                ]);
                    $conversion = $this->url_get_contents('https://api.bitaps.com/market/v1/ticker/btcusd',false);

                    
                       $package_amount = $upgrade_fee / $conversion->data->last ;  
                    

                  
                     $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->id,
                                        'sponsor'=>'',
                                         'matrix'=>6,
                                         'amount_usd'=>$upgrade_fee,
                                        'amount_btc'=>$package_amount,
                                        'payment_method'=>'bitcoin',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>$payment_details->payment_code,
                                        'invoice'=>$payment_details->invoice,
                                        'address'=>$payment_details->address,
                                        'payment_data'=>json_encode($payment_details),
                                          'event'=>'account',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ;  
 
                   
                   

                     $title = trans('ewallet.credit_fund');
                    $sub_title =  trans('ewallet.credit_fund');
                    $base =  trans('ewallet.credit_fund');
                    $method =  trans('ewallet.credit_fund');

                     return view('app.user.ewallet.bitaps',compact('payment_details','data','package_amount','setting','base','sub_title','method','title'));
                }else{

                    $data['items'] = [
                        [
                            'name' => Config('APP_NAME'),
                            'price' => $upgrade_fee,
                            'qty' => 1
                        ]
                    ];

                   $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->id,
                                        'sponsor'=>'',
                                         'matrix'=>0,
                                         'amount_btc'=>$upgrade_fee,
                                         'amount_usd' => $upgrade_fee ,
                                        'payment_method'=>'paypal',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>'paypal-account-'.$invoice_id,
                                        'invoice'=>'paypal-account-'.$invoice_id,
                                        'address'=>'paypal-account-'.$invoice_id,
                                        'payment_data'=>json_encode([]),
                                        'event'=>'account',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 
                   

                    $data['invoice_id'] = $invoice_id ;
                     $data['invoice_description'] = "Order #{$invoice_id} Invoice";
                    $data['return_url'] = url('user/paypal/addfund/success',$invoice_id);
                    $data['cancel_url'] = url('user/creditfund');

                    $total = 0;
                    foreach($data['items'] as $item) {
                        $total += $item['price']*$item['qty'];
                    }

                    $data['total'] = $total; 
                    $response = self::$provider->setExpressCheckout($data);
                    return redirect($response['paypal_link']);
                }

                
            

    }



    public function ipaysuccess(Request $request,$id,$username)
    {

         $title = trans('ewallet.credit_fund');
            $sub_title =  trans('ewallet.credit_fund');
           
            $base =  trans('ewallet.credit_fund');
            $method =  trans('ewallet.credit_fund');
        try {
              PostbackLog::create(['response'=>json_encode($request->all())]) ;

              $setting = PendingbtcRegister::find($id);
              $status = file_get_contents('https://community.ipaygh.com/v1/gateway/json_status_chk?invoice_id='.$username.'&merchant_key=tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f');

              $status =json_decode($status,true);
 
              $status = $status[$username]['status'] ;
               return view('app.user.ewallet.ipay',compact('payment_details','pacakge_amount','setting','title','sub_title','base','method'));  
             

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

             Session::flash('flash_notification',array('message'=>'Your transaction canceled','level'=>'error'));

            return redirect('user/creditfund');
               
             

        } catch (Exception $e) {
           
        }
    }


     function url_get_contents ($Url,$params) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($params){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
        }

          

         $output = curl_exec($ch);

        curl_close($ch);
        return  json_decode($output);
    }


    

}
