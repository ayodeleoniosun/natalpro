<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_request', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('user_id');
            $table->enum('language', ['english', 'yoruba', 'hausa', 'igbo'])->default('english');
            $table->string('mother');
            $table->string('child');
            $table->string('dob');
            $table->string('gender');
            $table->timestamps();
            $table->unsignedInteger('active_status');

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('invoice_id')->references('id')->on('invoice');
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
        Schema::dropIfExists('vaccination_request');
    }
}
