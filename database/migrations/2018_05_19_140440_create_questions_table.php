<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id');
            $table->string('title');
            $table->string('content',1000);
            $table->string('hint');
            $table->integer('difficulty');
            $table->integer('type');
            $table->boolean('is_discuss')->nullable();
            $table->string('include');
            $table->integer('admin_id');
            $table->integer('is_public');//題目是否公開
            $table->string('answer')->nullable();
            $table->integer('count')->default('0');
            $table->float('correct_rate')->default('0');
            $table->string('input_student')->nullable();
            $table->string('output_student')->nullable();
            $table->string('input_admin')->nullable();
            $table->string('output_admin')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
