<?php

use App\Modules\V1\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vaccination_amount')->nullable();
            $table->string('kit_amount')->nullable();
            $table->string('welcome_message')->nullable();
            $table->timestamps();
            $table->unsignedInteger('active_status')->default(1);

            $table->foreign('active_status')->references('id')->on('active_status');
        });

        Setting::create([
            'vaccination_amount' => 100,
            'kit_amount' => 100,
            'welcome_message' => 'We rejoice with you on the birth of your new baby. We  shall continually remind you of your vaccinations from when the need arises.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
