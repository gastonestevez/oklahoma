<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFkStockColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('stock', function (Blueprint $table) {
        $table->unsignedBigInteger('color_id')->nullable();
        $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('stock', function (Blueprint $table) {
        $table->dropForeign(['color_id']);
        $table->dropColumn('color_id');
      });
    }
}
