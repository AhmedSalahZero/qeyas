<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQeyasNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qeyas_news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('photo');
            $table->string('content');
            $table->date('news_date');
            $table->string('num_watches');
            $table->string('likes');
            $table->string('dislikes');
            $table->boolean('active');
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
        Schema::dropIfExists('qeyas_news');
    }
}
