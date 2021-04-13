<?php

namespace App\Modules\V1\Services;

use App\Handlers\SmsHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Models\VaccinationRequest;
use App\Modules\V1\Models\VaccinationSms;
use App\Modules\V1\Models\VaccinationSmsSample;
use Illuminate\Support\Facades\Log;
use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VaccinationService implements VaccinationRepository
{
    public function index()
    {
    }

    public function request(array $data)
    {
        $fullname = strtolower($data['first_name'])."".strtolower($data['last_name']);
        $is_email_generated = false;
        
        if (!isset($data['email_address']) || empty($data['email_address'])) {
            $currentTime = Carbon::now();
            $date = $currentTime->toArray();
            $email_address = $fullname."_".$date['micro']."@gmail.com";
            $user = User::getUserByEmail($email_address);
            
            while ($user) {
                $email_address = $fullname."_".$date['micro']."@gmail.com";
            }

            $is_email_generated = true;
        } else {
            $email_address = strtolower($data['email_address']);
        }

        $is_valid_email = ApiUtility::validate_email($email_address);

        if (!$is_valid_email) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Please enter a valid email address'
            ];
        }
        
        $user = User::getUserByEmail($email_address);
        
        if ($user) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'User with this email address exist. Kindly use a different email address'
            ];
        }
        
        DB::beginTransaction();

        if (!$user) {
            $user = (new UserService)->signUp([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'email_address' => $email_address,
                'password' => bcrypt($email_address),
                'is_email_generated' => $is_email_generated
            ]);
        }

        if ($user) {
            $vaccination_request_id = VaccinationRequest::GenerateRequestId(6);
            
            $vaccination_request = VaccinationRequest::create([
                'request_id' => $vaccination_request_id,
                'user_id' => $user->id,
                'mother' => strtolower($data['mother']),
                'child' => strtolower($data['child']),
                'dob' => $data['dob'],
                'gender' => strtolower($data['gender']),
                'amount' => strtolower($data['amount'])
            ]);

            VaccinationRequest::generateVaccinationCycles($vaccination_request);

            $setting = Setting::orderBy('id')->limit(1)->first();
            $status = VaccinationRequest::SendSms('NatalPro', $user->phone_number, $setting->welcome_message);
            Log::info("Vaccination Welcome SMS: " . $status);
        }

        DB::commit();

        return [
            'status' => 'success',
            'label' => 'success',
            'message' => 'Vaccination request successfully added.'
        ];
    }
}
