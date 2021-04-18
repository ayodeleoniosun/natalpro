<?php

namespace App\Modules\V1\Services;

use App\Handlers\SmsHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Enum\VaccinationInterval;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Models\VaccinationRequest;
use App\Modules\V1\Models\VaccinationSmsSample;
use Illuminate\Support\Facades\Log;
use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VaccinationService implements VaccinationRepository
{
    public function index()
    {
        $vaccinations = VaccinationRequest::orderBy('id', 'DESC')->get();
        
        return $vaccinations->map(function ($vaccination) {
            return VaccinationRequest::resource($vaccination);
        });
    }

    public function show($id)
    {
        $vaccination = VaccinationRequest::find($id);
        
        if (!$vaccination) {
            return [
                'status' => 'error',
                'message' => 'Vaccination request not found'
            ];
        }
        
        $vaccination = VaccinationRequest::resource($vaccination);

        return [
            'status' => 'success',
            'vaccination' => $vaccination
        ];
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

        $phone_number_exists = User::where([
            'phone_number' => ApiUtility::phoneNumberToDBFormat($data['phone_number']),
            'active_status' => ActiveStatus::ACTIVE
        ])->exists();

        if ($phone_number_exists) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'User with this phone number exist. Kindly use a different phone number'
            ];
        }
        
        try {
            DB::beginTransaction();

            if (!$user) {
                $user = (new UserService)->signUp([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone_number' => $data['phone_number'],
                    'email_address' => $email_address,
                    'password' => $email_address,
                    'is_email_generated' => $is_email_generated
                ]);
            }

            if ($user) {
                $vaccination_request_id = VaccinationRequest::GenerateRequestId(6);
                $vaccination_amount = Setting::where('id', 1)->value('vaccination_amount');

                $vaccination_request = VaccinationRequest::create([
                    'request_id' => $vaccination_request_id,
                    'user_id' => $user->id,
                    'mother' => strtolower($data['mother']),
                    'child' => strtolower($data['child']),
                    'dob' => $data['dob'],
                    'language' => strtolower($data['language']),
                    'gender' => strtolower($data['gender']),
                    'amount' => $vaccination_amount
                ]);

                VaccinationRequest::generateVaccinationCycles($vaccination_request);

                $welcome_message = VaccinationSmsSample::where([
                    'language' => $vaccination_request->language,
                    'interval' => VaccinationInterval::AT_BIRTH,
                    'active_status' => ActiveStatus::ACTIVE
                ])->value('sms');

                $status = SmsHandler::SendSms($user->phone_number, $welcome_message);
                Log::info("Vaccination Welcome SMS: " . $status);

                VaccinationCycle::where([
                    'vaccination_request_id' => $vaccination_request->id,
                    'interval' => VaccinationInterval::AT_BIRTH,
                ])->update(['active_status' => ActiveStatus::DEACTIVATED]);
            }

            DB::commit();

            return [
                'status' => 'success',
                'label' => 'success',
                'message' => 'Vaccination request successfully added.'
            ];
        } catch (\Exception $e) {
            Log::error('Registering vaccination request =>' . $e);
            DB::rollback();
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Error occurred while registering vaccination request.'
            ];
        }
    }

    public function smsSamples()
    {
        $samples = VaccinationSmsSample::select('interval')->distinct()->get();
    
        $all_samples = $samples->map(function ($sample) {
            $sample->vaccination_interval = VaccinationCycle::VACCINATION_CYCLES[$sample->interval];
            $sample->sms_samples = VaccinationSmsSample::where('interval', $sample->interval)->get();
            return $sample;
        });

        return [
            'samples' => $all_samples,
            'intervals' => VaccinationCycle::VACCINATION_CYCLES
        ];
    }

    public function viewSmsSamples(string $interval)
    {
        return [
            'samples' => VaccinationSmsSample::where('interval', $interval)->get(),
            'identifier' => $interval,
            'interval' => VaccinationCycle::VACCINATION_CYCLES[$interval]
        ];
    }
}
