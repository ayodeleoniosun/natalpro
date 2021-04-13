<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSmsSample extends Model
{
    use HasFactory;
    
    protected $table = 'vaccination_sms_sample';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vaccinationCycle()
    {
        return $this->hasMany(VaccinationCycle::class, 'vaccination_request_id');
    }
}
