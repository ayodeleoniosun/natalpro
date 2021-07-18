<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_code');
            $table->string('price');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('payment_id');
            $table->longText('description');
            $table->timestamps();
            $table->unsignedInteger('active_status');

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('payment_id')->references('id')->on('payment');
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
        Schema::dropIfExists('invoice');
    }
}
