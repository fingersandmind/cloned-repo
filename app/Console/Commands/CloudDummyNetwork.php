<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Artisan;
use Storage;
use App\User;

class CloudDummyNetwork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloud:dummynetwork  {limit}';

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


        $start = $this->argument('limit') ;

       
              
        // STARTHERE:
        $bar = $this->output->createProgressBar(3000);

        $jsonData = Storage::disk('local')->exists($start.'-data.json') ? json_decode(Storage::disk('local')->get($start.'-data.json')) : [] ; 

        $this->info('Fetching users from server   => '.$start.'-data.json') ; 

        foreach ($jsonData as $key => $value) {

                    $uniqid =uniqid() ;
                        $bar->advance();                 

                    $data['firstname'] = $value->user_detail_name ;
                    $data['lastname'] =  $value->user_detail_second_name ;
                    $data['email'] = $uniqid.'@iraisers.org' ;
                    $data['username'] = $value->user_name;
                    $data['reg_by'] = 'api' ;
                    $data['cpf'] = 'cpf' ;
                    $data['transaction_pass'] = 'transaction_pass' ;
                    $data['password'] = '123456' ;  
                    $data['passport'] = 'passport' ;
                    $data['phone'] = $value->user_detail_mobile ;
                    $data['gender'] = $value->user_detail_gender ;
                    $data['country'] = 'IN' ;
                    $data['state'] = $value->user_detail_state ;
                    $data['city'] = $value->user_detail_city ;
                    $data['address'] = $value->user_detail_address .' ' .$value->user_detail_address2 ;
                    $data['zip'] = '987654' ;
                    $data['location'] = '13325' ;
                    $data['package'] = '1' ;  
                    
                    $placement_id =  $sponsor_id  = User::where('username',$value->sponsor_id)->first()->id ;

                     if(User::where('username',$value->user_name)->exists()){
                        $this->error('user already registered username ' .$value->user_name .' || user id : ') ;
                     }else{ 
                       $re = User::add($data,$sponsor_id,$placement_id); 
                         
                        
                     }
                    // $this->callSilent('tree:update');


        }

        $start = $start +3000 ;  
        $bar->finish();
        // GOTO  STARTHERE ;

        // 

             

        
    }
}
