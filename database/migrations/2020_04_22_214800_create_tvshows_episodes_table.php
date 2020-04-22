<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvshowsEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvshows_episodes', function (Blueprint $table) {
            $table->unsignedBigInteger('episode_id');
            $table->unsignedBigInteger('tvshow_id');
            $table->unsignedBigInteger('tvshow_season_id');
            $table->string('description');
            $table->unsignedBigInteger('video_id');
            $table->timestamps();

            // foreign
            $table->foreign('video_id')->references('id')->on('videos');
            $table->foreign('tvshow_id')->references('id')->on('tvshows');
            $table->foreign('tvshow_season_id')->references('id')->on('tvshows_seasons');

            // primary key
            $table->primary(['episode_id', 'tvshow_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvshows_episodes');
    }
}
