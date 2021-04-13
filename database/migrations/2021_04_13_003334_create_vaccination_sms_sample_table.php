<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationSmsSampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vaccination_intervals = ['at_birth', '6_weeks', '10_weeks', '14_weeks', '6_months', '9_months', '12_months', '15_months', '18_months', '2_years'];

        Schema::create('vaccination_sms_sample', function (Blueprint $table) use ($vaccination_intervals) {
            $table->increments('id');
            $table->enum('interval', $vaccination_intervals);
            $table->longText('sms');
            $table->enum('language', ['english', 'yoruba', 'hausa']);
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

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
        Schema::dropIfExists('vaccination_sms_sample');
    }
}
