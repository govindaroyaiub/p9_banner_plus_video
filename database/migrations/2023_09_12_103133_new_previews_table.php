<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewPreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_previews_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_name');
            $table->BigInteger('logo_id');
            $table->string('color');
            $table->integer('is_logo');
            $table->integer('is_footer');
            $table->integer('is_version')->default(0); //0 = no verion, 1 = there are versions
            $table->integer('uploaded_by_user_id');
            $table->integer('uploaded_by_company_id');
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
        Schema::dropIfExists('new_previews_table');
    }
}
