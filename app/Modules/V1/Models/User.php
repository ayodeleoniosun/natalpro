<?php

namespace App\Modules\Api\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $hidden = [
        'password',
        'token_expires_at'
    ];

    public function fullname()
    {
        return ucwords(sprintf("%s %s", $this->first_name, $this->last_name));
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function picture()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function vaccinationRequest()
    {
        return $this->hasMany(VaccinationRequest::class, 'user_id');
    }

    public static function getUserByEmail($email)
    {
        return self::where('email_address', $email)->first();
    }
}
