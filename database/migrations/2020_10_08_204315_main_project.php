<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MainProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_project', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_name');
            $table->BigInteger('logo_id');
            $table->string('color');
            $table->integer('project_type'); //0 = banner, 1 = video
            $table->integer('is_logo');
            $table->integer('is_footer');
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
        Schema::dropIfExists('main_project');
    }
}
