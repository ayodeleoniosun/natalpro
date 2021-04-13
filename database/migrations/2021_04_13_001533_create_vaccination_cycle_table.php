<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationCycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vaccination_intervals = ['at_birth', '6_weeks', '10_weeks', '14_weeks', '6_months', '9_months', '12_months', '15_months', '18_months', '2_years'];

        Schema::create('vaccination_cycle', function (Blueprint $table) use ($vaccination_intervals) {
            $table->increments('id');
            $table->unsignedInteger('vaccination_request_id');
            $table->enum('interval', $vaccination_intervals)->default($vaccination_intervals[0]);
            $table->string('vaccination_date');
            $table->string('week_before');
            $table->string('day_before');
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('vaccination_request_id')->references('id')->on('vaccination_request');
            $table->foreign('active_status')->references('id')->on('active_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccination_cycle');
    }
}
