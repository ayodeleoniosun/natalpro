<?php

namespace App\Jobs;

use App\Handlers\SmsHandler;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Models\VaccinationSmsSample;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendVaccinationReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cycle;
    protected $duration;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cycle, $duration)
    {
        $this->cycle = $cycle;
        $this->duration = $duration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sms = VaccinationSmsSample::where([
            'language' => $this->cycle->vaccinationRequest->language,
            'interval' => $this->cycle->interval,
            'active_status' => ActiveStatus::ACTIVE
        ])->value('sms');

        $gender = ($this->cycle->vaccinationRequest->gender == 'male') ? 'His' : 'Her';
        $vaccination_date = date("F, jS, Y", strtotime($this->cycle->vaccination_date));
        $additional_message = '';
        
        $week_before = [
            'english' => 'See you next week',
            'yoruba' => 'A o maa reti yin ni ọsẹ to n bọ.',
            'hausa' => 'Mu hadu a mako mai zuwa',
            'igbo' => 'Lee gị n\'izu na-abịa'
        ];

        $day_before = [
            'english' => 'See you tomorrow',
            'yoruba' => 'A o maa reti yin ni ola.',
            'hausa' => 'Zamu jira ku gobe',
            'igbo' => 'Anyị ga-atụ anya gị echi'
        ];

        $duration_message = ($this->duration == VaccinationCycle::WEEK_BEFORE) ? $week_before[$this->cycle->vaccinationRequest->language] : $day_before[$this->cycle->vaccinationRequest->language];

        switch ($this->cycle->vaccinationRequest->language) {
            case 'english':
                $additional_message = $gender.' vaccination is on '.$vaccination_date.'. '.$duration_message;
                break;

            case 'yoruba':
                $additional_message = 'Ajesara re wa ni '.$vaccination_date.'. '.$duration_message;
                break;

            case 'hausa':
                $additional_message = 'Alurar rigakafin sa ta kasance a watan '.$vaccination_date.'. '.$duration_message;
                break;

            case 'igbo':
                $additional_message = 'Ọgwụ mgbochi ya bụ na '.$vaccination_date.'. '.$duration_message;
                break;

            default:
                $additional_message = $gender.' vaccination is on '.$vaccination_date.'. '.$duration_message;
        }
        
        $sms = $sms.'. '.$additional_message;
        $status = app(SmsHandler::class)->SendSms($this->cycle->vaccinationRequest->user->phone_number, $sms);
        
        Log::info($this->duration.' vaccination reminder SMS for '.$this->cycle->vaccinationRequest->mother.' ('.$this->cycle->vaccinationRequest->user->phone_number.') : '.$status);

        $vaccination_cycle = VaccinationCycle::find($this->cycle->id);

        if ($this->duration === VaccinationCycle::WEEK_BEFORE) {
            $vaccination_cycle->week_before_sms_status = true;
            $vaccination_cycle->save();
        }
        if ($this->duration === VaccinationCycle::DAY_BEFORE) {
            $vaccination_cycle->day_before_sms_status = true;
            $vaccination_cycle->active_status = ActiveStatus::DEACTIVATED;
            $vaccination_cycle->save();
        }
    }
}
