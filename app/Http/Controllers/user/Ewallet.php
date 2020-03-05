<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use DB;
use Auth;
use Validator;
use App\EwalletModel;
use App\User;
use App\Mail;
use App\Commission;
use App\Sponsortree;
use App\Payout;
use App\Balance;
use App\Debit;
use App\UserDebit;
use App\UserAccounts;
use App\PendingbtcRegister;
use App\PostbackLog;
use Datatables;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\user\UserAdminController;

use Srmklive\PayPal\Services\ExpressCheckout;



class Ewallet extends UserAdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


    protected static  $provider ;


     public function __construct()
    {
     
        self::$provider = new ExpressCheckout;    
    }


    public function index(Request $request)
    {
        
         $title     = trans('ewallet.title');
        $sub_title = trans('ewallet.sub_title');
        $base      = trans('ewallet.title');
        $method    = trans('ewallet.method'); 

        if (!session('wallet_type')) {
            Session::put('wallet_type', 'All');
        }
        return view('app.user.ewallet.wallet',compact('title', 'user', 'sub_title', 'base', 'method'));
    }

    
    public function data(Request $request)
    {         

        $amount = 0;
        $users1 = array();
        $users2 = array();
        //echo $user_id;die();
        $users1 = Commission::select('commission.id', 'user.username', 'from.username as fromuser', 'commission.payment_type', 'commission.user_id', 'commission.payable_amount', 'commission.created_at')


            ->join('user_accounts as fromaccount', 'fromaccount.id', '=', 'commission.from_id')
            ->join('users as from', 'from.id', '=', 'fromaccount.user_id')


            ->join('user_accounts as toaccount', 'toaccount.id', '=', 'commission.user_id')
            ->join('users as user', 'user.id', '=', 'toaccount.user_id')

            ->where('commission.user_id','=',Auth::user()->default_account)
            ->orderBy('commission.id', 'desc');



        $users2 = Payout::select('payout_request.id', 'users.username', 'users.username as fromuser', 'payout_request.status as payment_type', 'payout_request.user_id', 'payout_request.amount as payable_amount', 'payout_request.created_at')  
             ->join('user_accounts', 'user_accounts.id', '=', 'payout_request.user_id')
            ->join('users', 'users.id', '=', 'user_accounts.user_id') 
            ->where('payout_request.user_id','=',Auth::user()->default_account)
            ->orderBy('payout_request.id', 'desc');

        $users3 = UserDebit::select('user_debit.id', 'from.username as fromuser', 'user.username', 'user_debit.payment_type', 'user_debit.user_id', 'user_debit.debit_amount', 'user_debit.created_at')

             ->join('user_accounts as fromaccount', 'fromaccount.id', '=', 'user_debit.from_id')
            ->join('users as from', 'from.id', '=', 'fromaccount.user_id')
             ->join('user_accounts as toaccount', 'toaccount.id', '=', 'user_debit.user_id')
            ->join('users as user', 'user.id', '=', 'toaccount.user_id')
            ->where('user_debit.user_id','=',Auth::user()->default_account)
            ->orderBy('user_debit.id', 'desc');

        $count = $users1->count() + $users2->count() + $users3->count();
         $data = $users1->union($users2)->union($users3)->skip($request->start)->take($request->length)->orderBy('created_at', 'DESC');


      // die();

        return Datatables::of($data)
            ->edit_column('fromuser', '@if ($payment_type =="released") Adminuser @else {{$fromuser}} @endif')
            ->edit_column('user_id', '@if ($payment_type =="released" || $payment_type =="fund_transfer" || $payment_type =="plan_purchase") <span >{!!$payable_amount!!}</span> @else <span class="">0</span>@endif')
            ->edit_column('payable_amount', '@if ($payment_type =="released" || $payment_type =="fund_transfer" || $payment_type == "plan_purchase") <span>0</span> @else <span class="">{{round($payable_amount,2)}}</span>@endif')
            ->edit_column('payment_type', ' @if ($payment_type =="released") Payout released @else <?php  echo str_replace("_", " ", "$payment_type") ;  ?> @endif')
            ->remove_column('id')
            ->setTotalRecords($count)
            ->escapeColumns([])
            ->make();

            
    }

    public function fund(){
        $title = trans('wallet.fund_transfer');
            $sub_title =  trans('wallet.fund_transfer');
           
            $base =  trans('wallet.fund_transfer');
            $method =  trans('wallet.fund_transfer');

            $user_balance = Balance::where('user_id',Auth::user()->id)->value('balance') ;
           return view('app.user.ewallet.fund',compact('title','countries','user','sub_title','base','method','user_balance'));
    }

     public function creditfund(){
            $title = trans('ewallet.credit_fund');
            $sub_title =  trans('ewallet.credit_fund');
           
            $base =  trans('ewallet.credit_fund');
            $method =  trans('ewallet.credit_fund');

            return view('app.user.ewallet.creditfund',compact('title','countries','user','sub_title','base','method','user_balance'));
    }


    public function fundtransfer(Request $request){

          $validator=Validator::make($request->all(),[
                'username'=>'required|exists:users',
                'amount'=>'required'                 
                ]);
            if($validator->fails()){

                return  redirect()->back()->withErrors($validator);
            }else{


                if(Balance::where('user_id',Auth::user()->default_account)->value('balance') >= $request->amount){
                
                    $plan = UserAccounts::where('id',Auth::user()->default_account)->first()->matrix ;

                    $account = User::where('username',$request->username)->value('id');
                    $user_id = UserAccounts::where('user_id',$account)->where('matrix',$plan)->first()->id ;

                    Commission::create([
                        'user_id'=>$user_id,
                        'from_id'=>Auth::user()->default_account,
                        'total_amount'=>$request->amount,
                        'payable_amount'=>$request->amount,
                        'payment_type'=>'fund_transfer',
                        ]); 
                    Balance::where('user_id',$user_id)->increment('balance',$request->amount);

                    Balance::where('user_id',Auth::user()->default_account)->decrement('balance',$request->amount);
                    Debit::create([
                        'user_id'=>Auth::user()->default_account,
                        'to_userid'=>$user_id,
                        'total_amount'=>$request->amount,
                        'payable_amount'=>$request->amount,
                        'payment_type'=>'fund_transfer',
                        ]);

                    Session::flash('flash_notification',array('message'=>trans('wallet.amount_credited'),'level'=>'success'));

                    return redirect()->back();

                }else{
                     Session::flash('flash_notification',array('message'=>trans('wallet.not_enough_balance'),'level'=>'error'));

                    return redirect()->back();
                }
                
            }

    }




    public function addcreditfund(Request $request){

          $validator=Validator::make($request->all(),[
                'amount'=>'required',
                'payment'=>'required'                 
                ]);
            if($validator->fails()){

                return  redirect()->back()->withErrors($validator);
            }else{

                  $invoice_id= uniqid();
                if($request->payment == 'ipaygh'){

                     $conversion = $this->url_get_contents('https://dev.kwayisi.org/apis/forex/usd/ghs',false);

                    $package_amount = $request->amount  * $conversion->rate; 

                    
                    $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->default_account,
                                        'sponsor'=>'NA',
                                        'matrix'=>0,
                                        'amount_usd'=>$request->amount,
                                        'amount_btc'=>$package_amount,
                                        'payment_method'=>'ipaygh',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>'ipay-addfund-'.$invoice_id,
                                        'invoice'=>'ipay-addfund-'.$invoice_id,
                                        'address'=>'ipay-addfund-'.$invoice_id,
                                        'payment_data'=>json_encode([]),
                                        'event'=>'addfund',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 

 
                        echo '<form id="ipaygh" method=POST action="https://community.ipaygh.com/gateway">
                            <input type=hidden name=merchant_key value="tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f" />
                            <input type=hidden name=invoice_id value="'.$invoice_id.'" />
                            <input type=hidden name=success_url value="'.url('user/paymentnotify/success/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=cancelled_url value="'.url('user/paymentnotify/canceled/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=deferred_url value="'.url('user/paymentnotify/success/'.$setting->id,$invoice_id).'" />
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

                    

                     $package_amount = round($request->amount / $conversion->data->last,5);

                     $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->default_account,
                                        'sponsor'=>'',
                                         'matrix'=>0,
                                         'amount_btc'=>$package_amount,
                                         'amount_usd' => $request->amount ,
                                        'payment_method'=>'bitcoin',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>$payment_details->payment_code,
                                        'invoice'=>$payment_details->invoice,
                                        'address'=>$payment_details->address,
                                        'payment_data'=>json_encode($payment_details),
                                          'event'=>'addfund',
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
                            'price' => $request->amount,
                            'qty' => 1
                        ]
                    ];

                    $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>Auth::user()->email,
                                        'username'=>Auth::user()->default_account,
                                        'sponsor'=>'',
                                         'matrix'=>0,
                                         'amount_btc'=>$request->amount,
                                         'amount_usd' => $request->amount ,
                                        'payment_method'=>'paypal',
                                        'data'=>json_encode($request->all()),
                                        'payment_code'=>'paypal-addfund-'.$invoice_id,
                                        'invoice'=>'paypal-addfund-'.$invoice_id,
                                        'address'=>'paypal-addfund-'.$invoice_id,
                                        'payment_data'=>json_encode([]),
                                        'event'=>'addfund',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 
                   

                    $data['invoice_id'] = $invoice_id ;
                    $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
                    $data['return_url'] = url('user/paypal/addfund/success',$invoice_id);
                    $data['cancel_url'] = url('user/creditfund');

                    $total = 0;
                    foreach($data['items'] as $item) {
                        $total += $item['price']*$item['qty'];
                    }

                    $data['total'] = $total; 
                    // dd(self::$provider);
                    $response = self::$provider->setExpressCheckout($data); 
                    return redirect($response['paypal_link']);
                }

                
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

     

    public function paypalsuccess(Request $request,$invoice_id){

        $response = self::$provider->getExpressCheckoutDetails($request->token);

        $item = PendingbtcRegister::where('invoice_id',$invoice_id)->first();
        $item->payment_response_data = json_encode($response);
        if($response['ACK'] == 'Success'){
                 $item->status ='complete' ;
                 $item->save();

                 Session::flash('flash_notification',array('message'=>'you are completed payment, the amount will add in your account in few seconds','level'=>'success'));
                 return redirect('user/creditfund');
                  
        }else{
                 $item->status ='failed' ;
                 $item->save();
                 Session::flash('flash_notification',array('message'=>'Your transaction canceled','level'=>'error'));

                 return redirect('user/creditfund') ; 
        }
         


    }



    public function mytransfer(){

        $title =  trans('wallet.my_transfer');
        $sub_title =  trans('wallet.my_transfer');
        $base =  trans('wallet.my_transfer');
        $method =   trans('wallet.my_transfer');

        $data = Debit::join('users','users.id','=','debit_table.to_userid')->where('debit_table.user_id',Auth::user()->default_account)->select('debit_table.*','users.username as tousername')->paginate(10);
        return view('app.user.ewallet.mytransfer',compact('title','countries','user','sub_title','base','method','data'));
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
