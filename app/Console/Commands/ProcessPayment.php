<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\PendingbtcRegister ;
use App\User ;
use App\UserAccounts ;
use App\Commission ;

class ProcessPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process BTC payment ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         
         $list =PendingbtcRegister::where('status','new')->get();


         foreach ($list as $key => $value) {

            if($value->event == 'register'){
                 $data = json_decode($value->data,true) ;
                 $sponsor_id  = User::where('username',$value->sponsor)->value('id') ;
                 $placement_id = $sponsor_id ;//UserAccounts::where('user_id',$sponsor_id)->where('matrix',$value->matrix)->value('id');          
                 $re = User::add($data,$sponsor_id,$placement_id); 
            }elseif($value->event == 'addfund'){
                $re = Commission::Creditamounttowallet($value);
            }elseif ($data->event =='account') {
                $re = UserAccounts::addnewaccount($data) ;
            }

            if($re->id){

                PendingbtcRegister::where('id',$value->id)->update(['status'=>'finished']) ;
                $this->callsilent('tree:update') ;                
            }



         }
    }
}
