<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Storage ;
use DB ;

class CreateJsonExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:createjson';

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
        
        $start = 6000 ;
        try {

            STARTHERE :
             $this->line('start - ' .$start);
             $data = file_get_contents('https://iraisers.org/backoffice/login/exportjsonnetwork/'.$start) ;
             
             Storage::disk('local')->put('board/'.$start.'-board.json', $data);
             $this->line('end -- ' .$start);

             $start = $start + 3000 ;

             GOTO STARTHERE;
            
 
        } catch(Exception $e) {
 
            return ['error' => true, 'message' => $e->getMessage()];
 
        }


    }
}
