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

    protected $phone_number;
    protected $interval;
    protected $vaccination_date;
    protected $vaccination_request_id;
    protected $gender;
    protected $mother;
    protected $language;
    protected $duration;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $phone_number,
        $interval,
        $vaccination_date,
        $vaccination_request_id,
        $gender,
        $mother,
        $language,
        $duration
    ) {
        $this->phone_number = $phone_number;
        $this->interval = $interval;
        $this->vaccination_date = $vaccination_date;
        $this->vaccination_request_id = $vaccination_request_id;
        $this->gender = $gender;
        $this->mother = $mother;
        $this->language = $language;
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
            'language' => $this->language,
            'interval' => $this->interval,
            'active_status' => ActiveStatus::ACTIVE
        ])->value('sms');

        $gender = ($this->gender == 'male') ? 'His' : 'Her';
        $vaccination_date = date("F, jS, Y", strtotime($this->vaccination_date));
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

        switch ($this->language) {
            case 'english':
                $duration_message = ($this->duration == 'week_before') ? $week_before[$this->language] : $day_before[$this->language];
                $additional_message = $gender.' vaccination is on '.$vaccination_date.'. '.$duration_message;
                break;

            case 'yoruba':
                $duration_message = ($this->duration == 'week_before') ? $week_before[$this->language] : $day_before[$this->language];
                $additional_message = 'Ajesara re wa ni '.$vaccination_date.'. '.$duration_message;
                break;

            case 'hausa':
                $duration_message = ($this->duration == 'week_before') ? $week_before[$this->language] : $day_before[$this->language];
                $additional_message = 'Alurar rigakafin sa ta kasance a watan '.$vaccination_date.'. '.$duration_message;
                break;

            case 'igbo':
                $duration_message = ($this->duration == 'week_before') ? $week_before[$this->language] : $day_before[$this->language];
                $additional_message = 'Ọgwụ mgbochi ya bụ na '.$vaccination_date.'. '.$duration_message;
                break;

            default:
                $duration_message = ($this->duration == 'week_before') ? $week_before[$this->language] : $day_before[$this->language];
                $additional_message = $gender.' vaccination is on '.$vaccination_date.'. '.$duration_message;
        }
        
        $sms = $sms.' '.$additional_message;
        $status = app(SmsHandler::class)->SendSms($this->phone_number, $sms);
        Log::info($this->duration.' vaccination reminder SMS for '.$this->mother.' ('.$this->phone_number.') : '.$status);
        
        VaccinationCycle::where([
            'vaccination_request_id' => $this->vaccination_request_id,
            'interval' => $this->interval,
        ])->update(['active_status' => ActiveStatus::DEACTIVATED]);
    }
}
