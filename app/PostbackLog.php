<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostbackLog extends Model
{
    

    protected $table = 'postback_logs' ;

    protected $fillable = ['response'] ;
}
