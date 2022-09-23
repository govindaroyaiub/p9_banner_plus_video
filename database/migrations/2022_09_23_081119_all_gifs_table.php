<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllGifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_gifs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size_id');
            $table->string('size');
            $table->string('file_path');
            $table->bigInteger('project_id');
            $table->bigInteger('feedback_id');
            $table->bigInteger('category_id');
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
        Schema::dropIfExists('all_gifs');
    }
}
