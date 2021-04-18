<?php

namespace App\Modules\V1\Models;

use App\Modules\V1\Enum\VaccinationInterval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRequest extends Model
{
    use HasFactory;
    
    protected $table = 'vaccination_request';

    protected $fillable = [
        'request_id',
        'user_id',
        'mother',
        'child',
        'dob',
        'language',
        'gender',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cycles()
    {
        return $this->hasMany(VaccinationCycle::class, 'vaccination_request_id');
    }

    public static function GenerateRequestId($numlen)
    {
        $pastyear  = mktime(date("h"), date("i"), date("s"), date("m"), date("d"), date("Y")-50);

        $number_key = 3*(101*time());
        $st = strlen($number_key) - $numlen;
        $new_number_string = substr($number_key, $st, $numlen);
        $number_key = $new_number_string;
        
        $number_key2 = 3*(101*$pastyear);
        $st = strlen($number_key2) - $numlen;
        $new_number_string = substr($number_key2, $st, $numlen);
        $number_key2 = $new_number_string;

        return $number_key2;
    }

    public static function resource($vaccination)
    {
        $user = User::find($vaccination->user_id);
        
        return [
            'id' => $vaccination->id,
            'request_id' => $vaccination->request_id,
            'user' => [
                'fullname' => ucfirst($user->first_name." ".$user->last_name),
                'email_address' => $user->email_address,
                'phone_number' => $user->phone_number,
            ],
            'language' => ucfirst($vaccination->language),
            'mother' => ucfirst($vaccination->mother),
            'child' => ucfirst($vaccination->child),
            'dob' => Carbon::parse($vaccination->dob)->format('F jS, Y'),
            'gender' => ucfirst($vaccination->gender),
            'amount' => $vaccination->amount,
            'status' => ActiveStatus::find($vaccination->active_status)->name,
            'created_at' => Carbon::parse($vaccination->created_at)->format('F jS, Y h:i A'),
            'updated_at' => Carbon::parse($vaccination->updated_at)->format('F jS, Y, h:i A'),
            'cycles' => self::resourceCycles($vaccination->cycles)
        ];
    }

    public static function resourceCycles($cycles)
    {
        return $cycles->map(function ($cycle) {
            $cycle->interval = VaccinationCycle::VACCINATION_CYCLES[$cycle->interval];
            $cycle->vaccination_date = Carbon::parse($cycle->vaccination_date)->format('F jS, Y');
            $cycle->week_before = Carbon::parse($cycle->week_before)->format('F jS, Y');
            $cycle->day_before = Carbon::parse($cycle->day_before)->format('F jS, Y');
            $cycle->active_status = ActiveStatus::find($cycle->active_status)->name;
            
            return $cycle;
        });
    }

    public static function generateCycles($interval, $vaccination_request)
    {
        $vaccination_date = $vaccination_request->dob;
        $week_before = null;
        $day_before = null;
        
        switch ($interval) {
            case VaccinationInterval::SIX_WEEKS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addWeeks(6)->toDateString();
                break;

            case VaccinationInterval::TEN_WEEKS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addWeeks(10)->toDateString();
                break;

            case VaccinationInterval::FOURTEEN_WEEKS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addWeeks(14)->toDateString();
                break;

            case VaccinationInterval::SIX_MONTHS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addMonths(6)->toDateString();
                break;

            case VaccinationInterval::NINE_MONTHS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addMonths(9)->toDateString();
                break;

            case VaccinationInterval::TWELVE_MONTHS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addMonths(12)->toDateString();
                break;

            case VaccinationInterval::FIFTEEN_MONTHS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addMonths(15)->toDateString();
                break;

            case VaccinationInterval::EIGHTEEN_MONTHS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addMonths(18)->toDateString();
                break;

            case VaccinationInterval::TWO_YEARS:
                $vaccination_date = Carbon::parse($vaccination_request->dob)->addYears(2)->toDateString();
                break;
            
            default:
                $vaccination_date = $vaccination_date;

        }

        $week_before = Carbon::parse($vaccination_date)->subWeek()->toDateString();
        $day_before = Carbon::parse($vaccination_date)->subDay()->toDateString();

        return [
            'vaccination_request_id' => $vaccination_request->id,
            'interval' => $interval,
            'vaccination_date' => $vaccination_date,
            'week_before' => $week_before,
            'day_before' => $day_before
        ];
    }

    public static function generateVaccinationCycles($vaccination_request)
    {
        $vaccination_intervals = VaccinationInterval::VACCINATION_INTERVALS;

        foreach ($vaccination_intervals as $interval) {
            VaccinationCycle::create(self::generateCycles($interval, $vaccination_request));
        }
    }
}
