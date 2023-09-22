<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_banners_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('size');
            $table->string('file_path');
            $table->integer('size_id');
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
        Schema::dropIfExists('new_banners_table');
    }
}
