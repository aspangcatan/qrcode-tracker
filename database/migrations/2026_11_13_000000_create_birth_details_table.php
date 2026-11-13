<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthDetailsTable extends Migration
{
    /**
     * Birth certification fields that have no column in certificates.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birth_details', function (Blueprint $table) {
            $table->id();
            $table->integer('certificate_id')->index();
            $table->string('transaction', 100);
            $table->string('parents_status', 100)->nullable();
            $table->date('date_of_birth');
            $table->time('time_of_birth')->nullable();
            $table->string('weight', 50)->nullable();
            $table->string('mother_name', 200);
            $table->string('cell_no', 50)->nullable();
            $table->string('authorized_person', 200)->nullable();
            $table->date('date_received')->nullable();
            $table->date('date_claimed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_details');
    }
}
