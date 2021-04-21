<?php

namespace App\Modules\V1\Models;

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

    public function vaccinations()
    {
        return $this->hasMany(VaccinationRequest::class, 'user_id');
    }

    public static function getUserByEmail($email)
    {
        return self::where('email_address', $email)->first();
    }

    public static function validateUserCredentials($email, $password, $admin = null)
    {
        if ($admin) {
            $user = self::where([
                'role_type' => 'admin',
                'email_address' => $email
            ])->first();
        } else {
            $user = self::getUserByEmail($email);
        }
        
        if ($user) {
            return Hash::check($password, $user->password);
        }

        return false;
    }

    public static function resource($user)
    {
        $city = City::find($user->city_id)->name ?? null;
        $state = State::find($user->state_id)->name ?? null;
        $location = ($city && $state) ? $city.", ".$state : 'N/A';
        
        $vaccinations = $user->vaccinations->map(function ($vaccination) {
            return VaccinationRequest::resource($vaccination);
        });

        return [
            'id' => $user->id,
            'type' => self::USER_TYPE[$user->type],
            'full_name' => ucwords($user->first_name." ".$user->last_name),
            'email_address' => $user->email_address,
            'phone_number' => $user->phone_number,
            'state_id' => $user->state_id,
            'state' => $state,
            'city_id' => $user->city_id,
            'city' => $city,
            'location' => $location,
            'vaccinations' => $vaccinations,
            'status' => ActiveStatus::symbols($user->active_status),
            'created_at' => Carbon::parse($user->created_at)->format('F jS, Y h:i A'),
            'updated_at' => Carbon::parse($user->updated_at)->format('F jS, Y, h:i A'),
        ];
    }
}
