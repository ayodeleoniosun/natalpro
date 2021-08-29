<?php

namespace App\Modules\V1\Models;

use App\Modules\V1\Enum\VaccinationInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationCycle extends Model
{
    use HasFactory;
    
    protected $table = 'vaccination_cycle';

    protected $fillable = [
        'vaccination_request_id',
        'vaccination_date',
        'interval',
        'reminder_date'
    ];

    public const VACCINATION_CYCLES = [
        VaccinationInterval::AT_BIRTH => 'At birth',
        VaccinationInterval::SIX_WEEKS => '6 weeks',
        VaccinationInterval::TEN_WEEKS => '10 weeks',
        VaccinationInterval::FOURTEEN_WEEKS => '14 weeks',
        VaccinationInterval::SIX_MONTHS => '6 months',
        VaccinationInterval::NINE_MONTHS => '9 months',
        VaccinationInterval::TWELVE_MONTHS => '12 months',
        VaccinationInterval::FIFTEEN_MONTHS => '15 months',
        VaccinationInterval::EIGHTEEN_MONTHS => '18 months',
        VaccinationInterval::TWO_YEARS => '2 years',
    ];

    public function vaccinationRequest()
    {
        return $this->belongsTo(VaccinationRequest::class, 'vaccination_request_id');
    }

    public function vaccinationSms()
    {
        return $this->hasMany(VaccinationSms::class, 'vaccination_cycle_id');
    }
}
