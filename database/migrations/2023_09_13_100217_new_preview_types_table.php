<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewPreviewTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_preview_types_table', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('project_id');
            $table->integer('project_type'); //1 = banner, 2 = video, 3 = gif, 4 = social
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
        Schema::dropIfExists('new_preview_types_table');
    }
}
