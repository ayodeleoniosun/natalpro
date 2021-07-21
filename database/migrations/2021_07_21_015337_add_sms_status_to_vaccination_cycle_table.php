<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSmsStatusToVaccinationCycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccination_cycle', function (Blueprint $table) {
            $table->string('week_before_sms_status')->default(false)->after('week_before');
            $table->string('day_before_sms_status')->default(false)->after('day_before');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vaccination_cycle', function (Blueprint $table) {
            //
        });
    }
}
