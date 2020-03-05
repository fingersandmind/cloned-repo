<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Packages;
use App\Country;
use App\Settings;
use App\Voucher;
use App\PaymentType;
use App\Activity;
use App\AppSettings;
use App\Emails;
use App\Paypalcustomers;
use App\AuthorizePaymentModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use GeoIP;
use DB;
use Config;
use Mail;
use Crypt;
use Artisan;
use Session;
use CountryState;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Account;
use Stripe\Token;
use Carbon\Carbon;
use App\PendingbtcRegister;
use Srmklive\PayPal\Services\ExpressCheckout;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected static  $provider ;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        self::$provider = new ExpressCheckout;    
    }

    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($sponsorname = null)
    {

        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        if (User::where('username', '=',  $sponsorname)->count() > 0) {
            $sponsor_name = $sponsorname;  
        }else{
            $sponsor_name = User::find(1)->username;
        }

    
        $countries = CountryState::getCountries();
        $states = CountryState::getStates('MY');
        $leg = 'L';
        $placement_user =$sponsor_name ;
        $country = Country::all();
        $package = Packages::whereIn('id',[1,2,3])->get(); 
        $voucher_code=[];//Voucher::pluck('voucher_code');
        $payment_type=PaymentType::where('status','yes')->get();
        $transaction_pass=self::RandomString(); 


        

     

        return view('auth.register',compact('sponsor_name','countries','states','ip_latitude','ip_longtitude','leg','placement_user','package','transaction_pass','package','joiningfee'));
    }

     public function RandomString()
        {
                    $characters = "23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
                    $charactersLength = strlen($characters);
                    $randstring = '';
                    for ($i = 0; $i < 11; $i++) {
                        $randstring .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randstring;
        }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data, [

            //Login information
            'sponsor_name' => 'exists:users,username',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
            
            // Network information
            // 'role_id' => 'required',
            // 'rank_id' => 'required|max:255',
            // 'sponsor_id' => 'required|max:255',
            // 'status' => 'required|max:255',



            //Identification
            'firstname' => 'required|max:255',
            'lastname' => 'max:255',//OPTIONAL
            'gender' => 'required|max:255',  
            // 'date_of_birth' => 'required|max:255',
            // 'job_title' => 'required|max:255',
            'tax_id' => 'max:255', //TAX ID //VAT// National Identification Number //OPTIONAL
     

            //Contact Information
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'post_code' => 'max:255',//OPTIONAL            
            // 'latitude' => 'required|max:255',
            // 'longitude' => 'required|max:255',
            'address' => 'required|max:255',        
            'email' => 'required|email|max:255|unique:users',            
            'phone' => 'max:255',//OPTIONAL
            

            //Media
            // 'profile_photo' => 'required|max:255',
            // 'profile_coverphoto' => 'required|max:255',

            //Social links
            'twitter_username' => 'max:255', //OPTIONAL
            'facebook_username' => 'max:255', //OPTIONAL
            'youtube_username' => 'max:255', //OPTIONAL
            'linkedin_username' => 'max:255', //OPTIONAL
            'pinterest_username' => 'max:255', //OPTIONAL
            'instagram_username' => 'max:255', //OPTIONAL
            'google_username' => 'max:255', //OPTIONAL
            

            //Instant Messaging Ids (IM)
            'skype_username' => 'max:255', //OPTIONAL
            'whatsapp_number' => 'max:255', //OPTIONAL

            //Profile  
            'bio' => 'max:600', //OPTIONAL


        ]);

    }

    
    

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        // dd($request->all());
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }else{

            $data= $request->all();
           $data['reg_type']         = null;
            $data['cpf']              = null;
            $data['passport']         = null;
            $data['location']         = null;
            $data['reg_by']         = $request->payment;

            // $request->payment = 'free';

              /**
             * Checking if sponsor_id exist in users table
             * @var [boolean]
             */
            $sponsor_id = User::checkUserAvailable($data['sponsor']);
            /**
             * Checking if placement_user exist in users table
             * @var [type]
             */
            $placement_id =  $sponsor_id ;// User::checkUserAvailable($data['placement_user']);
            if (!$sponsor_id) {
                /**
                 * If sponsor_id validates as false, redirect back without registering , with errors
                 */
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }
            if (!$placement_id) {
                /**
                 * If placement_id validates as false, redirect back without registering , with errors
                 */
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }


            $joiningfee = Settings::value('joinfee');

            $package_amount = Packages::where('id',$request->package)->value('amount');

            $fee = $joiningfee + $package_amount;

            $paypal = Paypalcustomers::create([
                          'data'=>json_encode($data)  
                         ]); 



            if($request->payment == 'stripe'){


                    Stripe::setApiKey(config('services.stripe.secret'));
                    $customer=Customer::create([
                                'email' =>request('stripeEmail'),
                                'source' =>request('stripeToken')
                                ]);
                    $id = $customer->id;
                    $Charge=Charge::create([
                                'customer' =>$id,
                                'amount' => $fee * 100,
                                'currency' => 'cad'
                                ]);

                   

                }elseif($request->payment == 'authorize'){

                    $expiry = date('Y-m',strtotime($request->year.'-'.$request->month));
                    $amount = Packages::where('id',$request->package)->value('amount') ;
                    $invoice = time() ;
                    $responsechargecard = AuthorizePaymentModel::chargeCreditCard($expiry,$fee,$invoice,$request) ;  
                    if(!$responsechargecard){
                        return redirect()->back();
                    }
                    $paypal->paypal_recurring_responce = $responsechargecard->getSubscriptionId() ;
                    $paypal->save();

                   

                }elseif($request->payment == 'skrill'){
 
                        echo '  <form id="skrill" action="https://pay.skrill.com" method="post" > 
                             <input type="hidden" name="pay_to_email" value="demoqco@sun-fish.com">
                            <input type="hidden" name="return_url" value="'.url('skrill/success',$paypal->id).'" >
                            <input type="hidden" name="status_url" value="'.url('skrill-status',$paypal->id).'">
                            <input type="hidden" name="language" value="EN">
                            <input type="hidden" name="amount" value="'.$fee.'">
                            <input type="hidden" name="currency" value="USD">

                            <input type="hidden" name="pay_from_email" value="'.$request->email.'">
                            <input type="hidden" name="firstname" value="'.$request->firstname.'">
                            <input type="hidden" name="lastname" value="'.$request->lastname.'">

                            <input type="hidden" name="rec_amount" value="'.$fee.'">
                            <input type="hidden" name="rec_start_date" value="'.date('d/m/Y',strtotime('+30 days')).'">
                            <input type="hidden" name="rec_end_date" value="'.date('d/m/Y',strtotime('+20 years')).'">
                            <input type="hidden" name="rec_period" value="1">
                            <input type="hidden" name="rec_cycle" value="month">
                            <input type="hidden" name="rec_status_url" value="'.url('rec-skrill-status').'">
                            <input type="hidden" name="rec_status_url2" value="'.url('rec-skrill-status2').'">


                            <input type="hidden" name="detail1_description" value="Description:'.Config('APP_NAME').'">
                            <input type="hidden" name="detail1_text" value="'.Config('APP_NAME') .' : Subscription payment ">
                             ';
                    echo '  </form>';

                    echo '  <script type="text/javascript">';
                    echo "   document.forms['skrill'].submit()";   
                    echo '  </script>'; 

                    die();

                }elseif($request->payment == 'ipaygh'){

                    $invoice_id= uniqid();
                    $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>$request->email,
                                        'username'=>$request->username,
                                        'sponsor'=>$request->sponsor,
                                        'matrix'=>$request->package,
                                        'data'=>json_encode($data),
                                        'payment_code'=>'ipay-'.$invoice_id,
                                        'invoice'=>'ipay-'.$invoice_id,
                                        'address'=>'ipay-'.$invoice_id,
                                        'payment_data'=>json_encode([]),
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 

 
                        echo '<form id="ipaygh" method=POST action="https://community.ipaygh.com/gateway">
                            <input type=hidden name=merchant_key value="tk_ebd0adfa-4051-11e9-8e2c-f23c9170642f" />
                            <input type=hidden name=invoice_id value="'.$invoice_id.'" />
                            <input type=hidden name=success_url value="'.url('paymentnotify/success/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=cancelled_url value="'.url('paymentnotify/canceled/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=deferred_url value="'.url('paymentnotify/success/'.$setting->id,$invoice_id).'" />
                            <input type=hidden name=ipn_url value="'.url('paymentnotify/ipn').'" />
                            <input type=hidden name=currency value="GHS" />
                            <input type=hidden name=total value="16" /> 
                        </form>';

                    echo '  <script type="text/javascript">';
                    echo "  document.forms['ipaygh'].submit()  ";   
                    echo '  </script>'; 

                    die();

                }elseif($request->payment == 'paypal'){ 
                    
                    Session::put('paypal_id',$paypal->id);

                    $data = [];
                    $data['items'] = [
                        [
                            'name' => Config('APP_NAME'),
                            'price' => $fee,
                            'qty' => 1
                        ]
                    ];

                    $data['invoice_id'] = time();
                    $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
                    $data['return_url'] = url('/paypal/success',$paypal->id);
                    $data['cancel_url'] = url('register');

                    $total = 0;
                    foreach($data['items'] as $item) {
                        $total += $item['price']*$item['qty'];
                    }

                    $data['total'] = $total; 
                    $response = self::$provider->setExpressCheckout($data); 
                    return redirect($response['paypal_link']);
                     


                }else{


                    $setting = PendingbtcRegister::firstOrNew(['email' => $request->email,'username'=>$request->username]);

                     
                if (!$setting->exists) {
                    $url ='https://api.bitaps.com/btc/v1//create/payment/address' ;
                    $payment_details = $this->url_get_contents($url,[
                                                    'forwarding_address'=>'1CPKaZa9q19vu3ctMGqvbuP6Cfrto9G8G9',
                                                    'callback_link'=>url('bitaps/paymentnotify'),
                                                    'confirmations'=>3
                                                ]);

                      $conversion = $this->url_get_contents('https://api.bitaps.com/market/v1/ticker/btcusd',false);

                      $package_amount ;//=    $package_amount = $conversion->data->last /  $package_amount;

                    $invoice_id= uniqid();
                     $setting = PendingbtcRegister::create([
                                        'invoice_id'=>$invoice_id,
                                        'email'=>$request->email,
                                        'username'=>$request->username,
                                        'sponsor'=>$request->sponsor,
                                         'matrix'=>$request->package,
                                        'data'=>json_encode($data),
                                        'payment_code'=>$payment_details->payment_code,
                                        'invoice'=>$payment_details->invoice,
                                        'address'=>$payment_details->address,
                                        'payment_data'=>json_encode($payment_details),
                                        'status'=>'complete',
                                         "created_at" =>  \Carbon\Carbon::now(), 
                                         "updated_at" => \Carbon\Carbon::now(),  
                                        ]) ; 

                     Artisan::call('process:payment');
                    }else{
                        $payment_details = json_decode($setting->payment_data);
                        $data = json_decode($setting->data);
                    }

                   


                     return view('auth.bitaps',compact('payment_details','data','package_amount','setting'));
 
                }

 
 
            
          

            /**
            Complete user regsitration process 

            


           // $userresult = User::add($data,$sponsor_id,$placement_id);
            if(!$userresult){
                return redirect()->back()->withErrors(['Opps something went wrong'])->withInput();
            }

            

           


            

             $userPackage = Packages::find($data['package']);
          

            $sponsorname = $data['sponsor'];
            $placement_username = User::find($placement_id)->username;
             
            Activity::add("Added user $userresult->username","Added $userresult->username sponsor as $sponsorname and placement user as $placement_username ");

            Activity::add("Joined as $userresult->username","Joined in system as $userresult->username sponsor as $sponsorname and placement user as $placement_username",$userresult->id);

            Activity::add("Package purchased","Purchased package - $userPackage->package ",$userresult->id); 
         
 
            $email = Emails::find(1);
             
            $app_settings = AppSettings::find(1);
            
            Mail::send('emails.register',
                ['email'         => $email,
                    'company_name'   => $app_settings->company_name,
                    'firstname'      => $data['firstname'],
                    'name'           => $data['lastname'],
                    'login_username' => $data['username'],
                    'password'       => $data['password'],
                ], function ($m) use ($data, $email) {
                    $m->to($data['email'], $data['firstname'])->subject('Successfully registered')->from($email->from_email, $email->from_name);
                });


             
            return redirect("register/preview/" . Crypt::encrypt($userresult->id));
              **/
 

        }

       
    }



    public function paypalsuccess(Request $request,$id){

        $response = self::$provider->getExpressCheckoutDetails($request->token);

        $item = Paypalcustomers::find($id);
        $item->paypal_payment_responce = json_encode($response);
        $item->save();

        if($response['ACK'] == 'Success'){

            $data = json_decode($item->data,true); 

            $sponsor_id = User::checkUserAvailable($data['sponsor']); 
            $placement_id =  $sponsor_id ;
            if (!$sponsor_id) {
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }
            if (!$placement_id) {
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }

            $userresult = User::add($data,$sponsor_id,$placement_id);
            if(!$userresult){
                return redirect('register')->withErrors(['Opps something went wrong'])->withInput();                
            }
            
            $userPackage = Packages::find($data['package']);          

            $sponsorname = $data['sponsor'];
            $placement_username = User::find($placement_id)->username; 
            Activity::add("Added user $userresult->username","Added $userresult->username sponsor as $sponsorname and placement user as $placement_username in $legname Leg");

            Activity::add("Joined as $userresult->username","Joined in system as $userresult->username sponsor as $sponsorname and placement user as $placement_username in $legname Leg",$userresult->id);

            Activity::add("Package purchased","Purchased package - $userPackage->package ",$userresult->id);

 
            $email = Emails::find(1);
            /**
             * Returning app_settings to get company name
             * @var [collection]
             */
            $app_settings = AppSettings::find(1);
            /**
             * Sends mail to the user
             */
            Mail::send('emails.register',
                ['email'         => $email,
                    'company_name'   => $app_settings->company_name,
                    'firstname'      => $data['firstname'],
                    'name'           => $data['lastname'],
                    'login_username' => $data['username'],
                    'password'       => $data['password'],
                ], function ($m) use ($data, $email) {
                    $m->to($data['email'], $data['firstname'])->subject('Successfully registered')->from($email->from_email, $email->from_name);
                });


            /**
             * redirects to preview page after successful registration
             */
            return redirect("register/preview/" . Crypt::encrypt($userresult->id));

        }else{

                 return redirect('register')->withErrors(['Opps something went wrong'])->withInput(); 
        }
         


    }

    public function skrillsuccess(Request $request,$id){

        $item = Paypalcustomers::find($id);
        $item->paypal_payment_responce = json_encode($request->all());
        $item->save();    
          

        if($request->status == 2  ){
            $item->status  ='processing';
            $item->save();    

          $data = json_decode($item->data,true); 

            $sponsor_id = User::checkUserAvailable($data['sponsor']); 
            $placement_id =  $sponsor_id ;
            if (!$sponsor_id) {
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }
            if (!$placement_id) {
                return redirect()->back()->withErrors(['The sponsor not exist'])->withInput();
            }

            $userresult = User::add($data,$sponsor_id,$placement_id);
            if(!$userresult){
                return redirect('register')->withErrors(['Opps something went wrong'])->withInput();                
            }
            $item->status  ='finished';
            $item->save();    
            
            $userPackage = Packages::find($data['package']);          

            $sponsorname = $data['sponsor'];
            $placement_username = User::find($placement_id)->username;
            $legname = $data['leg'] == "L" ? "Left" : "right";            
            
            Activity::add("Added user $userresult->username","Added $userresult->username sponsor as $sponsorname and placement user as $placement_username in $legname Leg");

            Activity::add("Joined as $userresult->username","Joined in system as $userresult->username sponsor as $sponsorname and placement user as $placement_username in $legname Leg",$userresult->id);

            Activity::add("Package purchased","Purchased package - $userPackage->package ",$userresult->id);

 
            $email = Emails::find(1);
            /**
             * Returning app_settings to get company name
             * @var [collection]
             */
            $app_settings = AppSettings::find(1);
            /**
             * Sends mail to the user
             */
            Mail::send('emails.register',
                ['email'         => $email,
                    'company_name'   => $app_settings->company_name,
                    'firstname'      => $data['firstname'],
                    'name'           => $data['lastname'],
                    'login_username' => $data['username'],
                    'password'       => $data['password'],
                ], function ($m) use ($data, $email) {
                    $m->to($data['email'], $data['firstname'])->subject('Successfully registered')->from($email->from_email, $email->from_name);
                });
               

          return Response::json([
              'message' => 'OK'
          ], 200);

           
        }else{

          

        }

      }

      public function skrillreturn($id){


         $item = Paypalcustomers::findorFail($id); 


         $data =  json_decode($item->data,true);

         // echo $data['email'] ;
         $user_id =  User::where('email',$data['email'])->value('id');
         // dd($user_id);
         if($user_id){
                return redirect("register/preview/" . Crypt::encrypt($user_id));             
         }else{
            return redirect('register')->withErrors(['Opps something went wrong'])->withInput(); 
         }

      }


    public function preview($idencrypt)
    {
        $title     = trans('register.registration');
        $sub_title = trans('register.preview');
        $method    = trans('register.preview');
        $base      = trans('register.preview');
         
        $userresult      = User::with(['profile_info', 'profile_info.package_detail', 'sponsor_tree', 'tree_table', 'purchase_history.package'])->find(Crypt::decrypt($idencrypt));
 


        $userCountry = $userresult->profile_info->country;
        if ($userCountry) {
            $countries = CountryState::getCountries();
            $country   = array_get($countries, $userCountry);
        } else {
            $country = "A downline";
        }
        $userState = $userresult->profile_info->state;
        if ($userState) {
            $states = CountryState::getStates($userCountry);
            $state  = array_get($states, $userState);
        } else {
            $state = "unknown";
        }

        $sponsorId       = $userresult->sponsor_tree->sponsor;
        $sponsorUserName = \App\User::find($sponsorId)->username;


        if ($userresult) {
            // dd($user);
            return view('auth.preview', compact('title', 'sub_title', 'method', 'base', 'userresult', 'sponsorUserName', 'country', 'state', 'sub_title'));
        } else {
            return redirect()->back();
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
