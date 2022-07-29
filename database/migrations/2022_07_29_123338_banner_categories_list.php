<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BannerCategoriesList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_categories_list', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size');
            $table->string('file_path');
            $table->integer('size_id');
            $table->bigInteger('project_id');
            $table->bigInteger('feedback_id');
            $table->bigInteger('cat_id');
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
        Schema::dropIfExists('banner_categories_list');
    }
}
