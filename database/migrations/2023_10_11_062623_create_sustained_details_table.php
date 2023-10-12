<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSustainedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sustained_details', function (Blueprint $table) {
            $table->id();
            $table->integer('certificate_id');
            $table->text('noi');
            $table->text('doi');
            $table->text('poi');
            $table->text('toi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sustained_details');
    }
}
