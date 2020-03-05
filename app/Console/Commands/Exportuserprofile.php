<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\User ;
use App\Sponsortree ;
use App\PendingList ;
use App\Transactions ;
use App\Tree_Table ;
use App\ProfileModel ;
use App\UserAccounts ;

class Exportuserprofile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:userprofile'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       
        $skip = 0;
        $take = 1 ;
        STARTHERE :

        // $variable = Tree_Table::where('type','yes')->skip($skip)->take($take)->first();
        $variable = Tree_Table::where('user_id','30')->skip($skip)->take($take)->first();

        $levelone =  Tree_Table::getDownlinesperlevel([$variable->user_id],1);
        $leveltwo = Tree_Table::getDownlinesperlevel([$variable->user_id], 2);
        $levelthree = Tree_Table::getDownlinesperlevel([$variable->user_id], 3);
        $this->line('LINE  ----' . $variable->user_id );


    }
}

/*
 // $path = 'https://i.stack.imgur.com/koFpQ.png';        
        // $filename = basename($path);
        // Image::make($path)->save(public_path('images/' . $filename));
        $skip = 179420;
        $take = 1 ;

          STARTHERE :

          $this->line('LINE  ----' . $skip );
          $variable = DB::table('1820_auto_board_1')->skip($skip)->take($take)->get();

        foreach ($variable as $key => $value) {
 

            if($value->user_name == 'Iraisers'){
                continue;
            }else{



                if(User::where('username',$value->user_name)->exists() == false){

                    $username = $value->user_name ;
                    $user_details = json_decode(file_get_contents('https://iraisers.org/backoffice/login/exportjsonusername/'.$value->user_name)) ;
                   
                    if(isset($user_details->$username->user_name)){
                        $this->info('import user from live now  ');
                        User::updateinfo($user_details->$username) ;
                    }else{
                        $this->error('user not in live too ');
                        continue;
                    }  

                } 


                $placement_username = DB::table('1820_auto_board_1')->where('id',$value->father_id)->first()->user_name ;

                echo $value->user_name .' ---' .$placement_username ;

                if(User::where('username',$placement_username)->exists() == false){

                    $username = $placement_username ;
                    $user_details = json_decode(file_get_contents('https://iraisers.org/backoffice/login/exportjsonusername/'.$placement_username)) ;
                   
                    if(isset($user_details->$username->user_name)){
                        $this->info('import sponsor from live now  ');
                        User::updateinfo($user_details->$username) ;
                    }else{
                        $this->error('sponsor not in live too ');
                        continue;
                    }  

                }  

                // die('sss');

                $placement_id = User::where('username','=',$placement_username)->first()->default_account ; 
                $account_id = User::where('username','=',$value->user_name)->first()->default_account ; 
                $sponsor_id = Sponsortree::where('user_id',User::where('username','=',$value->user_name)->first()->id)->first()->sponsor ; ; 

                
                if(Tree_Table::where('user_id',$placement_id)->exists() == false){
                    $this->error('sponsor not in tree too ');
                        continue;  
                }

                if(Tree_Table::where('user_id',$account_id)->exists()){
                    $this->error('user  in tree  already ');
                        continue;  
                }
                $placement = Tree_Table::getPlacementId([$placement_id]);
 
                $tree          = Tree_Table::find($placement);
                $tree->user_id = $account_id;
                $tree->sponsor = $sponsor_id;
                $tree->type    = 'yes';
                $tree->save();

                Tree_Table::createVaccant($tree->user_id);


                Tree_Table::where('user_id',$tree->placement_id)->increment('level_1') ;
                if($tree->leg == 3){ 
                    Transactions::distributeLevelbonus($tree->placement_id ,1,1);
                }


                $second_upline = Tree_Table::getFatherID($tree->placement_id) ;  
                
                if($second_upline ==0){
                  GOTO SKIP;
                }

                Tree_Table::where('user_id',$second_upline)->increment('level_2') ; 
                      
                if($second_upline > 1 &&  Tree_Table::where('user_id',$second_upline)->value('level_2') == 9){              
                    Transactions::distributeLevelbonus($second_upline ,2,1);
                }
                 $third_upline = Tree_Table::getFatherID($second_upline) ; 
            
                if($third_upline == 0){
                  GOTO SKIP;
                }
                 Tree_Table::where('user_id',$third_upline)->increment('level_3') ; 
           
                if($third_upline > 1 && Tree_Table::where('user_id',$third_upline)->value('level_3') == 27){
                               
                  Transactions::distributeLevelbonus($third_upline ,3,1);
                  Transactions::distributeBoardbonus($third_upline ,1);

                 $pending_item = PendingList::create([
                        'user_id' =>$third_upline,
                        'from' => 1,
                        'next' => 2,
                        'sponsor' =>  Tree_Table::getFatherID($third_upline),
                        'leg' =>  Tree_Table::where('user_id',$third_upline)->value('leg'),
                    ]) ; 
                }





            }
            SKIP :
            
        }



            $skip = $skip + 1 ;

             GOTO STARTHERE;

*/