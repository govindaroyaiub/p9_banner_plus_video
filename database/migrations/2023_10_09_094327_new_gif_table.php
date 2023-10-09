<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewGifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_gif_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size_id');
            $table->string('size');
            $table->string('file_path');
            $table->bigInteger('version_id');
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
        Schema::dropIfExists('new_gif_table');
    }
}
