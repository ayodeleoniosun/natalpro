<?php

namespace App\Modules\V1\Models;

use App\Modules\ApiUtility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    
    protected $hidden = [
        'password',
        'token_expires_at'
    ];

    protected $fillable = ['first_name', 'last_name', 'email_address', 'phone_number', 'password'];

    public const USER_TYPES = ['nursing_mother', 'pregnant_women', 'healthcare_professional'];

    public const USER_TYPE = [
        'nursing_mother' => 'Nursing Mother',
        'pregnant_women' => 'Pregnant Women',
        'healthcare_professional' => 'Healthcare Professional'
    ];

    public function getFullNameAttribute()
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_to_user')->as('user_roles');
    }

    public function vaccinations()
    {
        return $this->hasMany(VaccinationRequest::class, 'user_id');
    }

    public function vaccinationCycles()
    {
        return $this->hasManyThrough(VaccinationCycle::class, VaccinationRequest::class);
    }

    public static function getUserByEmail($email)
    {
        return self::where('email_address', $email)->first();
    }

    public static function getUserByPhoneNumber($phone)
    {
        $phone = ApiUtility::phoneNumberToDBFormat($phone);
        return self::where('phone_number', $phone)->first();
    }

    public static function validateUserCredentials($username, $password, $admin = false)
    {
        if ($admin) {
            $user = self::where([
                'role_type' => 'admin',
                'email_address' => $username,
                'active_status' => ActiveStatus::ACTIVE
            ])->first();
        } else {
            $user = self::where([
                'role_type' => 'user',
                'active_status' => ActiveStatus::ACTIVE
            ])->where(function ($query) use ($username) {
                return $query->where('email_address', $username)
                    ->orWhere('phone_number', $username);
            })->first();
        }

        if ($user && Hash::check($password, $user->password)) {
            $user->token_expires_at = ApiUtility::next_one_month();
            $user->save();

            return $user;
        }

        return false;
    }

    public function getLocationAttribute()
    {
        $city = City::find($this->city_id)->name ?? null;
        $state = State::find($this->state_id)->name ?? null;
        
        if ($city || $state) {
            if ($city && !$state) {
                $location = $city;
            } elseif (!$city && $state) {
                $location = $state;
            } elseif ($city && $state) {
                $location = $city.", ".$state;
            }
        } else {
            $location = "N/A";
        }
            
        return $this->attributes['location'] = ucwords($location);
    }

    public function getStateAttribute()
    {
        return $this->attributes['state'] = ($this->state_id) ? ucwords(State::find($this->state_id)->name) : "N/A";
    }
    
    public function getCityAttribute()
    {
        return $this->attributes['city'] = ($this->city_id) ? ucwords(City::find($this->city_id)->name) : "N/A";
    }
    
    public static function resource($user)
    {
        $vaccinations = $user->vaccinations->map(function ($vaccination) {
            return (object) VaccinationRequest::resource($vaccination);
        });

        return [
            'id' => $user->id,
            'type' => self::USER_TYPE[$user->type],
            'full_name' => $user->full_name,
            'email_address' => $user->email_address,
            'phone_number' => $user->phone_number,
            'state_id' => $user->state_id,
            'state' => $user->state,
            'city_id' => $user->city_id,
            'city' => $user->city,
            'location' => $user->location,
            'vaccinations' => $vaccinations,
            'status' => ActiveStatus::symbols($user->active_status),
            'created_at' => Carbon::parse($user->created_at)->format('F jS, Y h:i A'),
            'updated_at' => Carbon::parse($user->updated_at)->format('F jS, Y, h:i A'),
        ];
    }
}
