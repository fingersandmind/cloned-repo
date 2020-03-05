<?php namespace App\Http\Controllers\Admin;

use App\Balance;
use App\Http\Controllers\Admin\AdminController;
use App\Mail;
use App\Payout;
use App\PointTable;
use App\ProfileInfo;
use App\Sponsortree;
use App\PurchaseHistory;
use App\Packages;
use App\User;
use App\Voucher;
use App\ProductPurchas;
use Auth;
use DB;
use Response;
use Carbon;
use App\Activity;
use App\UserAccounts;
use App\Models\Helpdesk\Ticket\Ticket;

use Illuminate\Http\Request;
class DashboardController extends AdminController
{

    public function index()
    {

       
         

 
        $title     = trans('dashboard.dashboard');
        $sub_title = trans('dashboard.your-dashboard');
        $base      = trans('dashboard.home');
        $method    = trans('dashboard.dashboard');

        $recent = PurchaseHistory::join('users', 'users.id', '=', 'purchase_history.user_id')
            ->join('packages', 'packages.id', '=', 'purchase_history.package_id')
            ->select('purchase_history.*', 'users.username', 'packages.package')
            ->orderby('purchase_history.id', 'DESC')
            ->take(5)
            ->get();
        $percentage_balance  = 0;
        $percentage_released = 0;
        $payout              = Payout::sum('amount');
        $balance             = Balance::sum('balance');
        if ($balance > 0) {
            $percentage_balance  = ($balance * 100) / ($payout + $balance);
            $percentage_released = ($payout * 100) / ($payout + $balance);
        }

        

          //SELECT sponsor , count(sponsor) FROM `sponsortree` WHERE sponsortree.type != 'vaccant' group by sponsor

          $top_recruiters =  [];
           

             

            $new_users = ProfileInfo::select(array('users.id', 'users.name', 'users.username', 'country','image','profile','cover', 'users.email', 'users.created_at'))
            ->join('users', 'users.id', '=', 'profile_infos.user_id')           
            ->where('admin', '<>', 1)
            // ->offset($request->start)
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();


 

        $count_new = count($new_users);

        $per_users   = User::getUserPercentage();
        $per_payout  = Payout::getPayoutPercentage();
        $per_mail    = Mail::perMail();
        $per_voucher = Voucher::perVoucher();

        $total_users    = User::where('admin', '<>', 1)->count();
        $total_messages = Mail::where('to_id', '=', 1)->count();
        $total_voucher  = 0;//Voucher::count();
        $total_amount   = ProductPurchas::sum('amount') ;
      


        $all_payout     = Payout::getPayoutAllDetails();
       
 
        $male_users_count  = ProfileInfo::where('user_id', '<>', 1)->where('gender','m')->count();
        $female_users_count  = ProfileInfo::where('user_id', '<>', 1)->where('gender','f')->count();


         $today_users_count = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-1 days')) )->count();
         $weekly_users_count = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )->count();
        $monthly_users_count = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-1 month')) )->count();
        $yearly_users_count = User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-1 year')) )->count();
       
       
        $packages_data = Packages::select(['id','package','amount','special'])->withCount('PurchaseHistoryR')->get();
        

        // $all_activities = Activity::with('user')->paginate(15);

        $all_activities = ProfileInfo::select(array('users.id', 'users.name', 'users.username', 'activity_log.description', 'users.email', 'users.created_at'))
            ->join('users', 'users.id', '=', 'profile_infos.user_id')
            ->join('activity_log', 'activity_log.user_id', '=', 'profile_infos.user_id')
            ->where('admin', '<>', 1)           
            ->paginate(15);


      
        return view('app.admin.dashboard.index', compact('title', 'per_users', 'recent', 'per_payout', 'per_mail', 'per_voucher', 'users', 'all_payout', 'new_users', 'count_new', 'percentage_released', 'percentage_balance', 'total_users', 'total_messages', 'total_voucher', 'total_amount', 'unread_count', 'unread_mail', 'point_details', 'sub_title', 'base', 'method','male_users_count','female_users_count','weekly_users_count','monthly_users_count','yearly_users_count','packages_data','all_activities','top_recruiters','today_users_count'));
    }


       /**
     * Fetching dashboard graph data to implement graph.
     *
     * @return type Json
     */
    public function ChartData($date111 = '', $date122 = '')
    {
        $date11 = strtotime($date122);
        $date12 = strtotime($date111);
        if ($date11 && $date12) {
            $date2 = $date12;
            $date1 = $date11;
        } else {
            // generating current date
            $date2 = strtotime(date('Y-m-d'));
            $date3 = date('Y-m-d');
            $format = 'Y-m-d';
            // generating a date range of 1 month
            $date1 = strtotime(date($format, strtotime('-1 month'.$date3)));
        }
        $return = '';
        $last = '';
        for ($i = $date1; $i <= $date2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);

            $created = \DB::table('tickets')->select('created_at')->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
            $closed = \DB::table('tickets')->select('closed_at')->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
            $reopened = \DB::table('tickets')->select('reopened_at')->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();

            $value = ['date' => $thisDate, 'open' => $created, 'closed' => $closed, 'reopened' => $reopened];
            $array = array_map('htmlentities', $value);
            $json = html_entity_decode(json_encode($array));
            $return .= $json.',';
        }
        $last = rtrim($return, ',');

        return '['.$last.']';

        // $ticketlist = DB::table('tickets')
        //     ->select(DB::raw('MONTH(updated_at) as month'),DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as closed'),DB::raw('SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as reopened'),DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as open'),DB::raw('SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as deleted'),
        //         DB::raw('count(*) as totaltickets'))
        //     ->groupBy('month')
        //     ->orderBy('month', 'asc')
        //     ->get();
        // return $ticketlist;
    }


    public function getGenderJson(){

            $male_users_count  = ProfileInfo::where('user_id', '<>', 1)->where('gender','m')->count();
            $female_users_count  = ProfileInfo::where('user_id', '<>', 1)->where('gender','f')->count();
            return response()->json(                
                [[
                'gender' => 'Male',
                "value"=> $male_users_count,
                "color"=> "#66BB6A"
                ],
                [
                'gender' => 'Female',
                "value" => $female_users_count,
                "color"=>"#EF5350"
                ]]
            , 200);
    }


    public function getUsersJoiningJson(){

        $users = DB::table('users')
          ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))
          ->orderBy('date', 'asc')
          ->groupBy('date')
          // ->take(15)
          ->get();
          return response()->json($users);
    }

    public function getUsersWeeklyJoiningJson(){

        // this week results
        $fromDate = Carbon\Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon\Carbon::now()->subDay()->toDateString();


        $users = DB::table('users')
          ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))
          ->whereBetween( DB::raw('DATE(created_at)'), [$fromDate, $tillDate] )
          ->orderBy('date', 'asc')
          ->groupBy('date')
          // ->take(15)
          ->get();
          return response()->json($users);
    }

    public function getUsersMonthlyJoiningJson(){

        // this week results
        $fromDate = Carbon\Carbon::now()->subDay()->startOfMonth()->toDateString(); // or ->format(..)
        $tillDate = Carbon\Carbon::now()->subDay()->toDateString();


        $users = DB::table('users')
          ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))
          ->whereBetween( DB::raw('DATE(created_at)'), [$fromDate, $tillDate] )
          ->orderBy('date', 'asc')
          ->groupBy('date')
          // ->take(15)
          ->get();
          return response()->json($users);
    }

    public function getUsersYearlyJoiningJson(){

        // this week results
        $fromDate = Carbon\Carbon::now()->subDay()->startOfYear()->toDateString(); // or ->format(..)
        $tillDate = Carbon\Carbon::now()->subDay()->toDateString();


        $users = DB::table('users')
          ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))
          ->whereBetween( DB::raw('DATE(created_at)'), [$fromDate, $tillDate] )
          ->orderBy('date', 'asc')
          ->groupBy('date')
          // ->take(15)
          ->get();
          return response()->json($users);
    }


    public function getPackageSalesJson(){

          // $purchases = DB::table('purchase_history')->join('packages', 'packages.id', '=', 'purchase_history.package_id')
          //   ->groupBy('purchase_history.package_id')
          //   ->get(['purchase_history.id', 'packages.package', DB::raw('count(packages.id) as items')]);
        
    
        // dd($purchases);

    // type,date,Alpha,Delta,Sigma
        // $purchases = DB::table('purchase_history')
        //   ->join('packages', 'purchase_history.package_id', '=', 'packages.id')
        //   // ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'),DB::raw('packages.package as package'))          
        //   ->select(
        //     DB::raw('DATE(purchase_history.created_at) as date'),
        //     DB::raw('packages.package as package')
        //     // DB::raw('count(*) as value')
        // )          
        //   // ->groupBy('date')
        //   ->orderBy('date', 'asc')
        //   // ->take(15)
        //   ->get();


        

        //convert into collection, group by "dept_name" key and then convert back into array
        // $data = collect($purchases)->groupBy('package')->all();
        // $data2 = collect($data)->groupBy('date')->all();

          // dd($data);
          // return response()->json($data);
         
        // $purchases_data = Packages::with('PurchaseHistoryR')
        // ->get();

        // $purchases_data = Packages::select(['id','package','amount','special'])
        // // ->with(['PurchaseHistoryR' => function($query) {
        // //     $query->select(['package_id']);
        // // }])
        // ->withCount('PurchaseHistoryR')
        // ->get();

        // return response()->json($purchases_data);


         $packages_data = Packages::select(['id','package','amount','special'])       
            // ->with(array('PurchaseHistoryR'=>function($query){
            //     $query->select(['package_id',DB::raw("DATE(created_at)  as date"),DB::raw('count(*) as value')])
            //     ->groupBy('date');
            // }))->get();

            /*
                SELECT * FROM `purchase_history`  
                WHERE DATE(`created_at`) = '2017-10-23'
                AND `package_id` = '1'
                ORDER BY `purchase_history`.`created_at`  ASC
            */

          
        ->with(array('PurchaseHistoryR'=>function($query){
            $query->select(['package_id',DB::raw("DATE(created_at)  as date"),DB::raw('count(*) as value')])
            ->groupBy('package_id')
            ->orderBy('date', 'asc')
            ->groupBy('date');
        }))->get();

        return response()->json($packages_data);
        // dd($packages_data);



        dd($packages_data);

           $package1 = DB::table('purchase_history')
              ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))              
              ->orderBy('date', 'asc')
              ->where('package_id', '1')
              ->groupBy('date')
          // ->take(15)
          ->get();     

          $package2 = DB::table('purchase_history')
              ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))              
              ->orderBy('date', 'asc')
              ->where('package_id', '2')
              ->groupBy('date')
          // ->take(15)
          ->get();

          $package3 = DB::table('purchase_history')
              ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))              
              ->orderBy('date', 'asc')
              ->where('package_id', '3')
              ->groupBy('date')
          // ->take(15)
          ->get();

           $datas = [];
           $datas['Elite'] = $package1->toArray();
           $datas['Premium'] = $package2->toArray();
           $datas['VIP'] = $package3->toArray();
            

          // $data = array_merge($package1->toArray(),$package2->toArray(),$package3->toArray());
          
          return response()->json($datas);


    }


    /**
     * Fetching tickets
     *
     * @return type Json
     */
    public function TicketsStatusJson($date111, $date122)
    {   
        
        // $date11 = date('Y-m-d', $date122);
        // $date12 =date('Y-m-d', $date111);

        // dd(date('m/d/Y', $date111));

        $date11 = strtotime($date111);
        $date12 = strtotime($date122);
        // dd($date111);

        // dd(strtotime(date('Y-m-d', strtotime('-1 month'.date('Y-m-d')))));

        if ($date11 && $date12) {
            $date2 = $date12;
            $date1 = $date11;
        } else {
            // generating current date
            $date2 = strtotime(date('Y-m-d'));
            $date3 = date('Y-m-d');
            $format = 'Y-m-d';
            // generating a date range of 1 month
            $date1 = strtotime(date($format, strtotime('-1 month'.$date3)));
        }
        $return = '';
        $last = '';
        for ($i = $date1; $i <= $date2; $i = $i + 86400) {
            $thisDate = date('Y-m-d', $i);

            $created = \DB::table('tickets')->select('created_at')->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
            $closed = \DB::table('tickets')->select('closed_at')->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
            $reopened = \DB::table('tickets')->select('reopened_at')->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();

            $value = ['date' => $thisDate, 'open' => $created, 'closed' => $closed, 'reopened' => $reopened];
            $array = array_map('htmlentities', $value);
            $json = html_entity_decode(json_encode($array));
            $return .= $json.',';
        }
        $last = rtrim($return, ',');

        return '['.$last.']';

        // $ticketlist = DB::table('tickets')
        //     ->select(DB::raw('MONTH(updated_at) as month'),DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as closed'),DB::raw('SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as reopened'),DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as open'),DB::raw('SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as deleted'),
        //         DB::raw('count(*) as totaltickets'))
        //     ->groupBy('month')
        //     ->orderBy('month', 'asc')
        //     ->get();
        // return $ticketlist;
    }


    public function getmonthusers()
    {

        for ($i = 1; $i <= 12; $i++) {
            echo $count = User::whereMonth('created_at', '=', $i)->whereYear('created_at', '=', date('Y'))->count();
            echo ",";
        }
    }

     public function switchaccount(Request $request)
    {

         if(UserAccounts::where('user_id',Auth::user()->id)->where('id',$request->key)->exists()  && Auth::user()->default_account != $request->key){
            User::where('id',Auth::user()->id)->update(['default_account'=>$request->key]) ;          
            return Response::json(['status'=>'redirect']) ;
         }else{
          return Response::json(['status'=>'failed']) ;

         }


    }
}
