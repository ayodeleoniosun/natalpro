<?php

namespace App\Console\Commands;

use App\Jobs\SendVaccinationReminder;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\VaccinationCycle;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VaccinationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccination:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends sms vaccination reminders to users a week and a day before their vaccination date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $this->queryReminder('week_before', $today);
        $this->queryReminder('day_before', $today);
    }

    private function queryReminder($duration, $date)
    {
        return VaccinationCycle::where([
            $duration => $date,
            'vaccination_cycle.active_status' => ActiveStatus::ACTIVE
        ])->join('vaccination_request', function ($join) {
            $join->on('vaccination_cycle.vaccination_request_id', '=', 'vaccination_request.id')
            ->where('vaccination_request.active_status', ActiveStatus::ACTIVE);
        })->join('user', function ($join) {
            $join->on('vaccination_request.user_id', '=', 'user.id')
            ->where('user.active_status', ActiveStatus::ACTIVE);
        })->select($this->relatedColumns())
        ->chunk(100, function ($vaccination_cycles) use ($duration) {
            foreach ($vaccination_cycles as $cycle) {
                $this->notificationBody($cycle, $duration);
            }
        });
    }

    private function relatedColumns()
    {
        return [
            'user.phone_number',
            'vaccination_cycle.interval',
            'vaccination_cycle.vaccination_date',
            'vaccination_cycle.vaccination_request_id',
            'vaccination_request.gender',
            'vaccination_request.mother',
            'vaccination_request.language'
        ];
    }

    private function notificationBody($cycle, $duration)
    {
        Log::info('Sending '.$duration.' vaccination reminder to '.$cycle->mother.' for interval '.$cycle->interval);
        
        SendVaccinationReminder::dispatch(
            $cycle->phone_number,
            $cycle->interval,
            $cycle->vaccination_date,
            $cycle->vaccination_request_id,
            $cycle->gender,
            $cycle->mother,
            $cycle->language,
            $duration
        );

        Log::info('Done sending '.$duration.' vaccination reminder to '.$cycle->mother.' for interval '.$cycle->interval);
    }
}
