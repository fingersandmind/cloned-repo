<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PendingBtcRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_btc_register', function (Blueprint $table) {
            $table->increments('id');
           
           //User informations ...
            $table->string('invoice_id');
            $table->string('email');
            $table->string('username');
            $table->string('sponsor');
            $table->integer('matrix');
            $table->text('data');

            //btc payment informations..
            $table->string('payment_code')->nulluble();
            $table->string('invoice')->nulluble();
            $table->string('address')->nulluble();
            $table->text('payment_data')->nulluble();
            $table->text('payment_response_data')->nulluble();

            $table->string('status')->default('new');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_btc_register');
    }
}
