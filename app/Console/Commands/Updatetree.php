<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\PendingList ;
use App\Tree_Table ;
use App\Tree_Table2 ;
use App\Tree_Table3 ;
use App\Tree_Table4 ;
use App\Transactions ;
use App\Sponsortree ;
use App\Incentives ;
use DB ;

class Updatetree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tree:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade users to next level and re arrange network ';

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

        $this->info('hii');
         
         $list = PendingList::where('status','pending')->get();

         foreach ($list as $key => $value) {

         	DB::beginTransaction();
         	try {
            $this->line('started  ' . $value->id );
                if($value->next == 2){
                        $MODEL = new Tree_Table2 ;                    
                }elseif($value->next == 3){
                        $MODEL = new Tree_Table3 ;                    
                }elseif($value->next == 4){
                        $MODEL = new Tree_Table4 ;                    
                }else{
                    continue;
                }

            //  check if any placement re arrage needed , 
            $downlines  =Tree_Table::where('placement_id',$value->user_id)
                                        ->pluck('user_id','leg') ;


            $vaccant_entries = [1=>1,2=>2,3=>3] ;

            foreach ($downlines as $leg => $dvalue) {
                if($MODEL::where('user_id',$dvalue)->exists()){

                    $dplacement = $MODEL::where('user_id',$dvalue)->value('placement_id') ;
                    
                    $dpos = $MODEL::where('user_id',$dvalue)->value('leg') ;

                    $MODEL::createOneVaccant($dplacement,$dpos) ;

                    unset($vaccant_entries[$leg]);

                    $MODEL::where('user_id',$dvalue)->update([ 'placement_id'=>$value->user_id ,'leg'=>$leg]) ;

                }
                 
            }
            

             $placement = $MODEL::getAvailableplacement($value->sponsor);

             $placement_id = $MODEL::getPlacementId([$placement]);

             $tree          = $MODEL::find($placement_id);
             $tree->user_id = $value->user_id;
             $tree->sponsor = $value->sponsor;
             $tree->type    = 'yes';
             $tree->save();

             $MODEL::createVaccant($value->user_id,$vaccant_entries);


             

           

             PendingList::where('id',$value->id)->update(['status'=>'complete']);

             $level_1 = $MODEL::getDownlinesperlevel([$tree->placement_id],1) ;
             
             $MODEL::where('user_id',$tree->placement_id)->update(['level_1'=>$level_1]) ;


              if($level_1 == 3){ 
                Transactions::distributeLevelbonus($tree->placement_id ,1,$value->next);  
               $incentive =  Incentives::distributeLevelIncentives($tree->placement_id ,1,$value->next); 
                
            }

            $second_upline = $MODEL::getFatherID($tree->placement_id) ;
            if($second_upline ==0){
                GOTO SKIP;
            }

            if($second_upline >=1){
                 $level_2 = $MODEL::getDownlinesperlevel([$second_upline],2) ;
                 $MODEL::where('user_id',$second_upline)->update(['level_2'=>$level_2]) ; 
            }
                        
            if($second_upline > 1 &&  $MODEL::where('user_id',$second_upline)->value('level_2') == 9){
            
              Transactions::distributeLevelbonus($second_upline ,2,$value->next); 
              $incentive = Incentives::distributeLevelIncentives($second_upline ,2,$value->next); 
            }

            /*******************THIRD LEVEL ******/

            $third_upline = $MODEL::getFatherID($second_upline) ; 
              if($third_upline ==0){
                GOTO SKIP;
            }

            if($third_upline >= 1 ){
                 $level_3 = $MODEL::getDownlinesperlevel([$third_upline],3) ;
                 $MODEL::where('user_id',$third_upline)->update(['level_3'=>$level_3]) ; 
             }
                        
            if($third_upline > 1 &&   $MODEL::where('user_id',$third_upline)->value('level_3') == 27){
              
              Transactions::distributeLevelbonus($third_upline ,3,$value->next); 
              $incentive =  Incentives::distributeLevelIncentives($third_upline ,3,$value->next); 
            }

              /*******************FOURTH LEVEL ******/

            $fourth_upline = $MODEL::getFatherID($third_upline) ; 
              if($fourth_upline ==0){
                GOTO SKIP;
            }

            if($fourth_upline >= 1 ){
                // $MODEL::where('user_id',$fourth_upline)->increment('level_4') ;
                $level_4 = $MODEL::getDownlinesperlevel([$fourth_upline],4) ;
                 $MODEL::where('user_id',$fourth_upline)->update(['level_4'=>$level_4]) ; 
            }
                        
            if($fourth_upline > 1 &&   $MODEL::where('user_id',$fourth_upline)->value('level_4') == 81){
              
              Transactions::distributeLevelbonus($fourth_upline ,4,$value->next); 
             $incentive =   Incentives::distributeLevelIncentives($fourth_upline ,4,$value->next); 
             $this->line('level 4 incentive') ;
            }

             $fifth_upline = $MODEL::getFatherID($fourth_upline) ; 
              if($fifth_upline ==0){
                GOTO SKIP;
            }

            if($fifth_upline >= 1 ){
                // $MODEL::where('user_id',$fifth_upline)->increment('level_5') ;
                $level_5 = $MODEL::getDownlinesperlevel([$fifth_upline],5) ;
                 $MODEL::where('user_id',$fifth_upline)->update(['level_5'=>$level_5]) ;
            }
                        
            if($fifth_upline > 1 &&   $MODEL::where('user_id',$fifth_upline)->value('level_5') == 243){
              
              if(PendingList::where('user_id',$fifth_upline)->where('from',$value->next)->exists() == false){

              
              Transactions::distributeLevelbonus($fifth_upline ,5,$value->next);
              Incentives::distributeLevelIncentives($fifth_upline ,5,$value->next); 
              Transactions::distributeBoardbonus($fifth_upline ); 

              $pending_item = PendingList::create([
                    'user_id' =>$fifth_upline,
                    'from' => $value->next,
                    'next' =>$value->next + 1 ,
                    'sponsor' =>   $MODEL::getFatherID($third_upline),
                    'leg' =>  $MODEL::where('user_id',$third_upline)->value('leg'),
                ]) ;
              }

            }

            SKIP:


             $this->line('complete ' . $value->id );

	              
	            DB::commit(); 
              
            } catch (Exception $e) {

            	DB::rollback();
            	
            	PendingList::where('id',$value->id)->update(['status'=>'failed']);
            	return false;
              
            }
           






         }



    }
}
