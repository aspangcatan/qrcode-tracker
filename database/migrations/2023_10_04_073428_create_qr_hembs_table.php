<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrHembsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_hembs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('patient_name',200);
            $table->string('date_training',200);
            $table->string('date_expiry',200);
            $table->string('institution',200);
            $table->text('url')->nullable();
            $table->text('hashed_value')->nullable();
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
        Schema::dropIfExists('qr_hembs');
    }
}
