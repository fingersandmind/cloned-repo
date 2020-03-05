<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingbtcRegister extends Model
{
    

    use SoftDeletes ;

    protected $table = 'pending_btc_register';

    protected $fillable = ['invoice_id','email','username','sponsor','data','payment_code','invoice','address','payment_data','matrix' ,'event','amount_usd','amount_btc','payment_method'];

}
