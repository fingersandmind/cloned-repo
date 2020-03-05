<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //
         Schema::create('tree_table', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sponsor');
            $table->integer('placement_id');
            $table->integer('leg');
            $table->string('type')->default('vaccant');
            $table->integer('level_1');
            $table->integer('level_2');
            $table->integer('level_3');
            $table->timestamps();
        });

        Schema::create('tree_table_2', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sponsor');
            $table->integer('placement_id');
            $table->integer('leg');
            $table->string('type')->default('vaccant');
            $table->integer('level_1');
            $table->integer('level_2');
            $table->integer('level_3');
            $table->integer('level_4');
            $table->integer('level_5');
            $table->timestamps();
        });
        
        Schema::create('tree_table_3', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sponsor');
            $table->integer('placement_id');
            $table->integer('leg');
            $table->string('type')->default('vaccant');
            $table->integer('level_1');
            $table->integer('level_2');
            $table->integer('level_3');
            $table->integer('level_4');
            $table->integer('level_5');
            $table->timestamps();
        });
        
         Schema::create('tree_table_4', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sponsor');
            $table->integer('placement_id');
            $table->integer('leg');
            $table->string('type')->default('vaccant');
            $table->integer('level_1');
            $table->integer('level_2');
            $table->integer('level_3');
            $table->integer('level_4');
            $table->integer('level_5');
            $table->timestamps();
        });
         Schema::create('tree_table_5', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sponsor');
            $table->integer('placement_id');
            $table->integer('leg');
            $table->string('type')->default('vaccant');
            $table->integer('level_1');
            $table->integer('level_2');
            $table->integer('level_3');
            $table->integer('level_4');
            $table->integer('level_5');
            $table->integer('level_6');
            $table->integer('level_7');
            $table->integer('level_8');
            $table->integer('level_9');
            $table->integer('level_10');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('tree_table');
       Schema::drop('tree_table_2');
       Schema::drop('tree_table_3');
       Schema::drop('tree_table_4');
       Schema::drop('tree_table_5');
    }
}
