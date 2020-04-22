<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvshowsSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvshows_seasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('description');
            $table->unsignedBigInteger('tvshow_id');
            $table->timestamps();

            // foreign key
            $table->foreign('tvshow_id')->references('id')->on('tvshows');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvshows_seasons');
    }
}
