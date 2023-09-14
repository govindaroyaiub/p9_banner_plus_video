<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_feedbacks_table', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('project_id');
            $table->integer('type_id');
            $table->integer('is_active')->default(1); // 1 = active, 0 = inactive
            $table->string('description');
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
        Schema::dropIfExists('new_feedbacks_table');
    }
}
