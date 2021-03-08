<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionAsksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_asks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('chapter_id');
            $table->string('title');
            $table->string('content');
            $table->boolean('is_sloved')->default(0);
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
        Schema::dropIfExists('discussion_asks');
    }
}
