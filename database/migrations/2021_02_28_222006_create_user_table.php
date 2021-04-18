<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['pregnant_women', 'nursing_mother', 'health_care_professional'])->default('nursing_mother');
            $table->enum('role_type', ['user', 'admin'])->default('user');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->unique();
            $table->boolean('is_email_generated')->default(false);
            $table->string('phone_number');
            $table->string('password');
            $table->string('bearer_token');
            $table->dateTime('token_expires_at');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('file_id')->default(1);
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('file_id')->references('id')->on('file');
            $table->foreign('state_id')->references('id')->on('state');
            $table->foreign('city_id')->references('id')->on('city');
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
        Schema::dropIfExists('user');
    }
}
