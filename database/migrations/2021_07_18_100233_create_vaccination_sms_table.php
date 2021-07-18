<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vaccination_cycle_id');
            $table->string('description');
            $table->longText('sms');
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('vaccination_cycle_id')->references('id')->on('vaccination_cycle');
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
        Schema::dropIfExists('vaccination_sms');
    }
}
