<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lobbies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
//          $table->integer('player0_id');
//          $table->integer('player1_id');
//          $table->integer('player2_id');
//          $table->integer('player3_id');
            $table->string('players');
            $table->string('mode');
            $table->timestamp('game_started_at');
            $table->timestamp('game_finished_at');
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
        Schema::drop('lobbies');
    }
}
