<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\ProfileInfo;
use Auth;
use View;
use App\Mail;
use App\AppSettings;
use Cache;
use Validator;
use CountryState;
use App\Activity;
use App\Ranksetting;
use App\Packages;
use App\Currency;
use App\Tree_Table;
use App\Tree_Table2;
use App\Tree_Table3;
use App\Tree_Table4;
use App\UserAccounts;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {        

         Schema::defaultStringLength(191); 

        view()->composer(['no-layout'],function($view){
            $app = AppSettings::find(1);          
            $view            
            ->with('app',$app)
            ->with('logo',$app->logo)
            ->with('logo_ico',$app->logo_ico);
        });

        view()->composer(['auth*'],function($view){
            $app = AppSettings::find(1);          
            $view            
            ->with('app',$app)
            ->with('logo',$app->logo)
            ->with('logo_ico',$app->logo_ico);
        });

        view()->composer(['site-*.base'],function($view){
            $app = AppSettings::find(1);          
            $view            
            ->with('app',$app)
            ->with('logo',$app->logo)
            ->with('logo_ico',$app->logo_ico);
        });



        view()->composer(['app.admin*'],function($view){
            
            $user = \App\User::with(['profile_info', 'profile_info.package_detail', 'sponsor_tree', 'tree_table', 'purchase_history.package'])->find(Auth::id());
            
            $presence = \App\User::isOnline(\Auth::id());
            if($presence == null){
                $presence = "false";
            }
            $profile = ProfileInfo::where('user_id',Auth::id())->get();
            //$profile = ProfileInfo::where('user_id',2)->get();
            
            $image =  $profile->first()->profile;
            if($image){
                if($image == 1){
                    $image = 'avatar-big.png';
                }
            }

            
            $unread_count = Mail::unreadMailCount(Auth::id());
            $unread_mail = Mail::unreadMail(Auth::id());
            $app = AppSettings::find(1);
            $activities = Activity::with('user')->where('user_id',Auth::id())->paginate(5);
            $accounts = UserAccounts::join('packages','packages.id','=','user_accounts.matrix')->where('user_id',Auth::user()->id)->pluck('package','user_accounts.id');
            $view            
            ->with('user',$user)
            ->with('presence',$presence)
            ->with('profile',$profile)
            ->with('unread_count',$unread_count)
            ->with('accounts',$accounts)
            ->with('unread_mail',$unread_mail)
            ->with('app',$app)
            ->with('logo',$app->logo)
            ->with('logo_ico',$app->logo_ico)
            ->with('image',$image)
            ->with('activities',$activities);
        });


        view()->composer(['app.user*'],function($view){
            

            $GLOBAL_USERRANK='NA' ;// Ranksetting::where('id',Auth::user()->rank_id)->value('rank_name'); 

            if(UserAccounts::find(Auth::user()->default_account)->matrix == 1){

                $GLOBAL_PACAKGE = ' Basic ' ;

            }else{

                $GLOBAL_PACAKGE = ' Premium' ;

            }

            

 
             $accounts = UserAccounts::join('packages','packages.id','=','user_accounts.matrix')->where('user_id',Auth::user()->id)->pluck('package','user_accounts.id');
           
            $USER_CURRENCY= 'USD';//Currency::find(ProfileInfo::where('user_id','=',Auth::user()->id)->value('currency'));
            $GLOBAL_RANK= Ranksetting::where('id',Auth::user()->rank_id)->value('rank_name');;

            

            $user = \App\User::with(['profile_info', 'profile_info.package_detail', 'sponsor_tree', 'tree_table', 'purchase_history.package'])->find(Auth::id());

 

            $silver = Tree_Table2::where('user_id',Auth::user()->default_account)->count();
            $gold = Tree_Table3::where('user_id',Auth::user()->default_account)->count();
            $diamond = Tree_Table4::where('user_id',Auth::user()->default_account)->count();
           
            
          
            
            $presence = \App\User::isOnline(\Auth::id());
            if($presence == null){
                $presence = "false";
            }
            $profile = ProfileInfo::where('user_id',Auth::id())->get();
            $image =  $profile->first()->profile;
            $unread_count = Mail::unreadMailCount(Auth::id());
            $unread_mail = Mail::unreadMail(Auth::id());
            $app = AppSettings::find(1);
            $activities = Activity::with('user')->where('user_id',Auth::id())->get();
            // dd($activities);
            $view            
            ->with('user',$user)
            ->with('presence',$presence)
            ->with('profile',$profile)
            ->with('unread_count',$unread_count)
            ->with('unread_mail',$unread_mail)
            ->with('accounts',$accounts)
            ->with('app',$app)
            ->with('logo',$app->logo)
            ->with('logo_ico',$app->logo_ico)
            ->with('image',$image)
            ->with('activities',$activities)
            ->with('GLOBAL_USERRANK',$GLOBAL_USERRANK)
            ->with('GLOBAL_PACAKGE',$GLOBAL_PACAKGE)
            ->with('USER_CURRENCY',$USER_CURRENCY)
            ->with('GLOBAL_RANK',$GLOBAL_RANK)
            ->with('silver',$silver)
            ->with('gold',$gold)
            ->with('diamond',$diamond);
           
        });



      
       


        
        Validator::extend('country', function($attribute, $value, $parameters, $validator) {            
            if(!empty($value)){
                $countries = collect(CountryState::getCountries());
                $flipped = $countries->flip();               
                if($flipped->contains($value) === true){
                 return true;
                }                
            }
            return false;
        });


        //ASLAM STOPPED FURTHER VALIDATION HOOKS BECAUSE THERE MIGHT NOT BE NEEDING TO VERIFY THE STATE CUZ SOMETIMES VALUE MIGHT NOT BE THERE
        
        // Validator::extend('state', function($attribute, $value, $parameters, $validator) {

        //     if(!empty($value) && !empty($parameters)){
        //         $country = collect($parameters);

        //         $states = collect(CountryState::getStates($country->first()));                
        //         if($states->isEmpty() === false){
        //             dd($states);
        //             dd('country got state');
        //         }                
        //     }else{
        //         // dd('maybe no states');
        //         return true;
        //     }
        //     return false;
        // });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
