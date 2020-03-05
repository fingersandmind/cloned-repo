<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\user\UserAdminController;
use App\Http\Controllers;
use Auth;
use DB;
use App\User;
use App\Sponsortree;
use App\Mail;
use App\Payout;
use App\AppSettings;
use App\Tree_Table;
use App\Balance;
use App\Commission;
use App\PointTable;
use App\PurchaseHistory;
use App\RsHistory;
use App\Currency;
use Carbon;
use Session;
use Validator;

class dashboard extends UserAdminController{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $title = trans('dashboard.method');
       
         
        // dd(Sponsortree::where('sponsor','=',Auth::user()->id)->pluck('user_id'));
        
        
        $balance = Balance::getTotalBalance(Auth::user()->default_account);

        $details = Payout::getUserPayoutDetails();
        $details = explode(',', $details);
        $percentage_balance = 0;
        $percentage_released = 0;

        if($details[0]+$balance != 0)
        $percentage_balance = ($balance*100)/($details[0]+$balance);
        if($details[0]+$details[1] !=0)
        $percentage_released = ($details[0]*100)/($details[0]+$details[1]);
          

        $base = trans('dashboard.base');
        $method = trans('dashboard.method');
        $sub_title = trans('dashboard.sub_title');
         $incentives=DB::table('incentives_list')
                         ->join('packages','packages.id','=','incentives_list.stage')
                         ->where('incentives_list.user_id',Auth::user()->default_account)
                         ->orderBy('incentives_list.id','DESC')
                         ->first();

       return view('app.user.dashboard.index', compact('title', 'balance','percentage_released','percentage_balance','total_bonus','sub_title','base','method','incentives'));
    }

    public function savedocument(Request $request){

            
            $validation = Validator::make($request->all(),[
                                'file' => 'required|mimes:jpeg,bmp,png,pdf',
                            ]);
            if($validation->fails()){

                return redirect()->back()->withErrors($validation);
            }

             if ($request->hasFile('file')) {
                    $image = $request->file('file');
                    $name = time().Auth::user()->username.'.'.$image->getClientOriginalExtension();
                    $destinationPath = storage_path('files/images/kyc');
                    $image->move($destinationPath, $name);

                    DB::table('user_documents')->insert([
                                                    'user_id'=>Auth::user()->id,
                                                    'file_name'=>$name,
                                                     
                                                    'approved'=>0,
                                                    'deleted'=>0,
                                                    'created_at'=>Carbon\Carbon::now(),
                                                    'updated_at'=>Carbon\Carbon::now(),
                                                ]) ;
                    // $this->save();

                    return back()->with('success','Image Upload successfully');
                }

    }
    public function getmonthusers(){
        $downline_users = array();
        Tree_Table::getDownlines(1,true ,Auth::user()->id,$downline_users);
        $users = Tree_Table::getDown();       
        print_r($users);
    }

     public function getUsersJoiningJson(){

        $users = DB::table('users')
          ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as value'))
          ->orderBy('date', 'asc')
          ->groupBy('date')
          ->whereIn('id',Sponsortree::where('sponsor',Auth::user()->id)->pluck('user_id'))
          ->get();
          return response()->json($users);
    }

     public function confirme_active(Request $request, $id,$activate){

        if(Sponsortree::where('user_id','=',$id)->value('sponsor') !=  Auth::user()->id){

            
             return redirect()->back()->withErrors(['Whoops, User not found ']);
        }
        
        $user_detail = User::find($request->user);

        if ($user_detail->confirmed != 1) {
            if($activate == 'activate'){
              $user_detail->confirmed = 1 ;
               DB::table('user_documents')->where('user_id',$request->user)->where('approved',0)->where('deleted',0)->update(['approved'=>1]);
            }else{
              $user_detail->confirmed = 0 ;
              DB::table('user_documents')->where('user_id',$request->user)->where('approved',0)->update(['deleted'=>1]);
            }
            $user_detail->save() ;
            Session::flash('flash_notification', array('message' => "Member $activate  succesfully", 'level' => 'success'));               
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(['Whoops, User not found ']);
        }
     }
     public function activate()
    {

        $title     = trans('users.activate_user');
        $sub_title = trans('users.activate_user');
        $base      = trans('users.activate_user');
        $method    = trans('users.activate_user');

 

        $users = User::join('profile_infos', 'profile_infos.user_id', '=', 'users.id') 
            ->join('sponsortree', 'sponsortree.user_id', '=', 'users.id')
            ->join('user_documents', 'user_documents.user_id', '=', 'users.id')
            ->join('packages', 'packages.id', '=', 'profile_infos.package')
            ->join('users as sponsors', 'sponsors.id', '=', 'sponsortree.sponsor')
            ->select('sponsors.username as sponsor', 'users.username', 'users.id', 'users.email', 'users.created_at', 'users.name', 'users.lastname', 'packages.package','user_documents.file_name')
            ->where('users.confirmed', '!=', '1')
            ->wherein('users.id',Sponsortree::where('sponsor','=',Auth::user()->id)->where('user_id','!=',0)->pluck('user_id'))
            ->where(function($j){
                $j->Where('user_documents.deleted','=',0) ;
            })
            ->paginate(10);


        return view('app.user.dashboard.activate', compact('title','sub_title','base','method', 'users'));
    }

}
