<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePendingBtcTableAddEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_btc_register', function (Blueprint $table) {
            $table->string('event')->default('register')->after('matrix') ;
            $table->double('amuont_btc')->default('0')->after('event') ;
            $table->double('amuont_usd')->default('0')->after('amuont_btc') ;
            $table->string('payment_method')->default('bitcoin')->after('amuont_usd') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_btc_register', function (Blueprint $table) {
            //
        });
    }
}
