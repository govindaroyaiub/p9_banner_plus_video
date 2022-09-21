<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('size_id');
            $table->string('codec');
            $table->string('aspect_ratio');
            $table->string('fps');
            $table->string('size');
            $table->string('poster_path')->nullable();
            $table->string('video_path');
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
        Schema::dropIfExists('all_videos');
    }
}
