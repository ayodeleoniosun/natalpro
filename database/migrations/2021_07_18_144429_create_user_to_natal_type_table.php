<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserToNatalTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_to_natal_type', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['pregnant_women', 'nursing_mother', 'health_care_professional'])->default('nursing_mother');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('user_id')->references('id')->on('user');
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
        Schema::dropIfExists('user_to_natal_type');
    }
}
