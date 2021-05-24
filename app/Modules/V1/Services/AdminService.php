<?php

namespace App\Modules\V1\Services;

use App\Modules\ApiUtility;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use App\Modules\V1\Repositories\AdminRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class AdminService implements AdminRepository
{
    public function dashboard()
    {
        $vaccinations = (new VaccinationService)->index();
        $users = (new UserService)->users();
        
        return [
            'vaccinations' => $vaccinations,
            'users' => $users
        ];
    }

    public function signIn(array $data)
    {
        if (!User::validateUserCredentials($data['email'], $data['password'], 'admin')) {
            return [
                'status' => 'error',
                'message' => 'Incorrect login details'
            ];
        }

        $user = User::getUserByEmail($data['email']);
        $user->token_expires_at = ApiUtility::next_one_month();
        $user->save();
        
        session(['user' => $user]);
        
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
                'message' => 'Settings successfully updated',
            ];
        } catch (Exception $e) {
            Log::info("Error while updating settings - ".$e);
            return [
                'status' => 'success',
                'message' => 'Settings not updated. Try again',
            ];
        }
    }
}
