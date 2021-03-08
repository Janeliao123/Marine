<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseUserListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_list_id');
            $table->string('acct');
            $table->string('name')->nullable();
            $table->integer('count')->default('0');
            $table->float('correct_rate')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_user_lists');
    }
}
