<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('package');
            $table->integer('amount')->default(0);
            $table->double('level_1')->default(0);
            $table->double('level_2')->default(0);
            $table->double('level_3')->default(0);
            $table->double('level_4')->default(0);
            $table->double('level_5')->default(0);
            $table->double('board')->default(0);
            $table->double('special')->default(0);
            $table->integer('matrix')->default(1);
          
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
        Schema::drop('packages');
    }
}
