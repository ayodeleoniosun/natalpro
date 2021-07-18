<?php

namespace App\Modules\V1\Services;

use App\Handlers\SmsHandler;
use App\Handlers\Flutterwave;
use App\Modules\ApiUtility;
use App\Modules\V1\Enum\VaccinationInterval;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\Invoice;
use App\Modules\V1\Models\Payment;
use App\Modules\V1\Models\PaymentStatus;
use App\Modules\V1\Models\PaymentType;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use App\Modules\V1\Models\UserToNatalType;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Models\VaccinationRequest;
use App\Modules\V1\Models\VaccinationSmsSample;
use Illuminate\Support\Facades\Log;
use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VaccinationService implements VaccinationRepository
{
    public function index(array $data)
    {
        if ($data['user_type'] === 'admin') {
            $vaccinations = VaccinationRequest::orderBy('id', 'DESC')->get();
        } else {
            $vaccinations = VaccinationRequest::where('user_id', $data['auth_user']->id)->orderBy('id', 'DESC')->get();
        }

        return $vaccinations->map(function ($vaccination) {
            return (object) VaccinationRequest::resource($vaccination);
        });
    }

    public function show(array $data)
    {
        if ($data['user_type'] === 'admin') {
            $vaccination = VaccinationRequest::find($data['id']);
        } else {
            $vaccination = VaccinationRequest::where([
                'id' => $data['id'],
                'user_id' => $data['auth_user']->id
            ])->first();
        }
        
        if (!$vaccination) {
            return [
                'status' => 'error',
                'message' => 'Vaccination request not found'
            ];
        }
        
        $vaccination = VaccinationRequest::resource($vaccination);

        return [
            'status' => 'success',
            'vaccination' => (object) $vaccination
        ];
    }

    public function request(array $data)
    {
        $is_email_generated = false;

        if (!isset($data['email_address']) || empty($data['email_address'])) {
            $email_address = ApiUtility::generateRandomEmail();
            $user = User::getUserByEmail($email_address);
            
            while ($user) {
                $email_address = ApiUtility::generateRandomEmail();
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
                'message' => 'Invalid email address'
            ];
        }
        
        $user = User::getUserByPhoneNumber($data['phone_number']);
        
        if ($user) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'User with this phone number exist. Kindly use a different phone number'
            ];
        }

        try {
            DB::beginTransaction();

            $user = app(UserService::class)->signUp([
                'first_name' => $data['child'],
                'last_name' => $data['mother'],
                'phone_number' => $data['phone_number'],
                'email_address' => $email_address,
                'password' => ApiUtility::phoneNumberToDBFormat($data['phone_number']),
                'is_email_generated' => $is_email_generated
            ], UserToNatalType::NURSING_MOTHER);
        
            $reference_code = ApiUtility::generateTransactionReference();
            $vaccination_amount = Setting::where('id', 1)->value('vaccination_amount');
            
            $payment = Payment::create([
                'payment_type_id' => PaymentType::FLUTTERWAVE,
                'payment_status_id' => PaymentStatus::NO_PAYMENT,
                'description' => 'Payment of vaccination reminder for '.strtolower($data['child']),
                'active_status' => ActiveStatus::PENDING
            ]);
            
            $invoice = Invoice::create([
                'reference_code' => $reference_code,
                'user_id' => $user->id,
                'payment_id' => $payment->id,
                'price' => $vaccination_amount,
                'description' => 'Payment of vaccination reminder for '.strtolower($data['child']),
                'active_status' => ActiveStatus::PENDING
            ]);

            VaccinationRequest::create([
                'invoice_id' => $invoice->id,
                'user_id' => $user->id,
                'mother' => strtolower($data['mother']),
                'child' => strtolower($data['child']),
                'dob' => $data['dob'],
                'language' => strtolower($data['language']),
                'gender' => strtolower($data['gender']),
                'active_status' => ActiveStatus::PENDING
            ]);

            DB::commit();

            $payment = app(Flutterwave::class)->vaccinationPayment($user, $vaccination_amount, $reference_code);
            
            return [
                'status' => 'success',
                'payment_link' => $payment->data->link
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

    public function callback(int $transaction_id, string $reference_id)
    {
        $transaction = app(Flutterwave::class)->verify($transaction_id);
        
        if ($transaction->status == 'success') {
            $invoice = Invoice::where([
                'reference_code' => $transaction->data->tx_ref,
                'active_status' => ActiveStatus::PENDING
            ])->first();

            if (!$invoice) {
                return [
                    'status' => 'error',
                    'label' => 'danger',
                    'message' => 'Invoice does not exist.'
                ];
            }

            $vaccination_request = VaccinationRequest::where([
                'invoice_id' => $invoice->id,
                'active_status' => ActiveStatus::PENDING
            ])->first();

            if (!$vaccination_request) {
                return [
                    'status' => 'error',
                    'label' => 'danger',
                    'message' => 'Vaccination request does not exist.'
                ];
            }

            DB::beginTransaction();

            $vaccination_request->active_status = ActiveStatus::ACTIVE;
            $vaccination_request->save();

            $payment = Payment::find($invoice->payment_id);
            $payment->payment_status_id = PaymentStatus::PAID;
            $payment->active_status = ActiveStatus::ACTIVE;
            $payment->save();

            $invoice->active_status = ActiveStatus::ACTIVE;
            $invoice->save();

            VaccinationRequest::generateVaccinationCycles($vaccination_request);
            
            VaccinationCycle::where([
                'vaccination_request_id' => $vaccination_request->id,
                'interval' => VaccinationInterval::AT_BIRTH,
            ])->update(['active_status' => ActiveStatus::DEACTIVATED]);
            
            DB::commit();

            $user = User::find($vaccination_request->user_id);
            
            $welcome_message = VaccinationSmsSample::where([
                'language' => $vaccination_request->language,
                'interval' => VaccinationInterval::AT_BIRTH,
                'active_status' => ActiveStatus::ACTIVE
            ])->value('sms');
            
            $welcome_message.="\nYour login details are as follow:\n";
            $welcome_message.="Phone number - ".$user->phone_number."\n";
            $welcome_message.="Password - ".$user->phone_number."\n";
            
            $status = app(SmsHandler::class)->SendSms($user->phone_number, $welcome_message);
            Log::info("Vaccination Welcome SMS to ".$user->phone_number." = ". $status);
            
            return [
                'status' => 'success',
                'label' => 'success',
                'message' => 'Vaccination request successfully submitted.'
            ];
        }

        return [
            'status' => 'error',
            'label' => 'danger',
            'message' => 'Invalid transaction ID.'
        ];
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

    public function optOut(array $data)
    {
        $vaccination = VaccinationRequest::where([
            'id' => $data['id'],
            'user_id' => $data['auth_user']->id,
            'active_status' => ActiveStatus::ACTIVE
        ])->first();
        
        if (!$vaccination) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Vaccination request not found or inactive'
            ];
        }

        DB::beginTransaction();

        $vaccination->active_status = ActiveStatus::DEACTIVATED;
        $vaccination->save();

        VaccinationCycle::query()
            ->where('vaccination_request_id', $vaccination->id)
            ->update(['active_status' => ActiveStatus::DEACTIVATED]);

        DB::commit();

        return [
            'status' => 'success',
            'label' => 'success',
            'message' => 'Done. You shall no longer receive SMS on this vaccination'
        ];
    }
}
