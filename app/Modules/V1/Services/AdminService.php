<?php

namespace App\Modules\V1\Services;

use App\Modules\V1\Models\City;
use App\Modules\V1\Models\Role;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Repositories\AdminRepository;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminService implements AdminRepository
{
    public function dashboard()
    {
        $data = [];
        $data['user_type'] = 'admin';

        $vaccinations = app(VaccinationService::class)->index($data);
        $users = app(UserService::class)->users();
        
        return [
            'vaccinations' => $vaccinations,
            'users' => $users
        ];
    }

    public function signIn(array $data)
    {
        $user = User::validateUserCredentials($data['username'], $data['password'], true);
        
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Incorrect login details'
            ];
        }

        session(['admin' => $user]);
        
        return [
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user
        ];
    }

    public function settings()
    {
        $settings = Setting::where('id', 1)->first();
        return ['settings' => $settings];
    }

    public function updateSettings(array $data)
    {
        $settings = Setting::find(1);

        if (!$settings) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Settings not found.',
            ];
        }

        try {
            $settings->vaccination_amount = $data['vaccination_amount'];
            $settings->kit_amount = $data['kit_amount'];
            $settings->welcome_message = $data['welcome_message'];
            $settings->save();

            return [
                'status' => 'success',
                'label' => 'success',
                'message' => 'Settings successfully updated',
            ];
        } catch (Exception $e) {
            Log::info("Error while updating settings - ".$e);
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Settings not updated. Try again',
            ];
        }
    }

    public function updatePassword(array $data)
    {
        return app(UserService::class)->changePassword($data);
    }
}
