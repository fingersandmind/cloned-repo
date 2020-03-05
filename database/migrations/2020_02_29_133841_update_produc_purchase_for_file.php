<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProducPurchaseForFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productspurchase', function (Blueprint $table) {
            $table->string('file')->default(null)->after('ends_at') ;
            $table->text('comments')->default(null)->after('file') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productspurchase', function (Blueprint $table) {
            //
        });
    }
}
