<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvshowsGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvshows_genres', function (Blueprint $table) {
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('tvshow_id');

            // foreign keys
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->foreign('tvshow_id')->references('id')->on('tvshows');

            // primary
            $table->primary(['genre_id', 'tvshow_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvshows_genres');
    }
}
