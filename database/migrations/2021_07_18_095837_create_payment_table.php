<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_type_id');
            $table->unsignedInteger('payment_status_id');
            $table->longText('description');
            $table->timestamps();
            $table->unsignedInteger('active_status');

            $table->foreign('payment_status_id')->references('id')->on('payment_status');
            $table->foreign('payment_type_id')->references('id')->on('payment_type');
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
        Schema::dropIfExists('payment');
    }
}
