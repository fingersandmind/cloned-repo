<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentivesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('stage');
            $table->integer('level');
            $table->string('incentive',600);
            $table->string('status')->default('pending') ;
            $table->string('comments')->nullable() ;
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incentives_list');
    }
}
