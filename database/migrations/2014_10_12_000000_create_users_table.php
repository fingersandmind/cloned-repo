<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('lastname')->default(false);
            $table->string('username')->unique(); // used for slug.
            // $table->string('user_id')->unique(); // used for slug.
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('transaction_pass', 60)->nullable();            
            $table->integer('rank_id');
            $table->integer('default_account')->default(1);
            $table->string('register_by')->default(false);
            $table->string('confirmation_code')->default(false);
            $table->string('hypperwalletid')->nullable();
            $table->string('hypperwallet_token')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->boolean('admin')->default(false);
            $table->rememberToken();
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
        Schema::drop('users');
    }

}
