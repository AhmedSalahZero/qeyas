<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adsense', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ad_name');
            $table->string('ad_photo');
            $table->string('ad_url');
            $table->string('show');
            $table->date('ad_end_date');
            $table->boolean('active');
            $table->integer('num_views');
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
        Schema::dropIfExists('adsense');
    }
}
