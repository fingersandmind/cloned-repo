<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingList extends Model
{
    

    protected $table = 'pending_list' ;

    protected $fillable = ['user_id','from','next','sponsor'] ;
}
