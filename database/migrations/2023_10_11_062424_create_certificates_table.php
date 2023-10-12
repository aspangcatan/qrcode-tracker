<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('certificate_no', 100);
            $table->string('health_record_no', 100);
            $table->date('date_issued');
            $table->string('patient', 150);
            $table->integer('age');
            $table->string('sex', 10)->nullable();
            $table->string('civil_status', 20)->nullable();
            $table->string('address', 200);
            $table->dateTime('date_examined');
            $table->string('doctor', 200);
            $table->string('doctor_designation', 200)->nullable();
            $table->string('doctor_license', 30);
            $table->string('requesting_person', 200)->nullable();
            $table->text('purpose')->nullable();
            $table->string('or_no', 200);
            $table->decimal('amount', 10, 2);
            $table->string('type', 100)->nullable();
            $table->integer('days_barred')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
