<?php

use App\Modules\V1\Models\VaccinationCycle;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustVaccinationReminderDatesInVaccinationCycleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccination_cycle', function (Blueprint $table) {
            $table->dropColumn('week_before');
            $table->dropColumn('day_before');
            $table->dropColumn('week_before_sms_status');
            $table->dropColumn('day_before_sms_status');
            $table->string('reminder_date')->after('vaccination_date');
            $table->boolean('reminder_sms_status')->default(false)->after('reminder_date');
        });

        VaccinationCycle::chunk(100, function ($cycles) {
            foreach ($cycles as $cycle) {
                $cycle->reminder_date = Carbon::parse($cycle->vaccination_date)->startOfWeek(Carbon::SUNDAY)->toDateString();
                $cycle->reminder_sms_status = $cycle->reminder_date < date("Y-m-d");
                $cycle->save();
            }
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
            $table->dropColumn('reminder_date');
            $table->dropColumn('reminder_sms_status');
        });
    }
}
