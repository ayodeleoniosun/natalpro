<?php

namespace App\Modules;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class ApiUtility
{
    public static function validate_email($email)
    {
        $emailCheck = preg_match("^[a-z\'\"0-9 +.]+([._-][+[a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$^", $email);
        
        if (!$emailCheck) {
            return false;
        }

        return true;
    }

    public static function generate_bearer_token()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public static function decode_bearer_token($request)
    {
        $header = $request->header('Authorization', '');
        
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return null;
    }

    public static function auth_user($request)
    {
        $now = Carbon::now()->toDateTimeString();
        $user = $request->auth_user;

        $user = User::where(
            [
                'id' => $user->id,
                'active_status' => ActiveStatus::ACTIVE
            ]
        )->whereDate('token_expires_at', '>=', $now)->first();
        
        if (!$user) {
            throw new CustomApiErrorResponseHandler("Unauthorized access.");
        }

        return $user;
    }

    public static function mail_subject_by_environment()
    {
        $environment = App::environment();

        if ($environment == 'production') {
            return '';
        }

        return '[' . strtoupper($environment) . '] ';
    }

    public static function next_one_month()
    {
        return Carbon::now()->addMonths(1)->toDateTimeString();
    }

    public static function generateTimeStamp()
    {
        $currentTime = Carbon::now();
        $date = $currentTime->toArray();
        $timeStamp = $date['year']."_".date("m")."_".date("d")."_".$date['micro'];
        return $timeStamp;
    }

    public static function phoneNumberToDBFormat($phone_number)
    {
        $phone_number = preg_replace('/[^0-9]/', '', $phone_number);

        if ($phone_number) {
            if (substr($phone_number, 0, 1) == '0') {
                $phone_number = '234' . substr($phone_number, 1);
            } elseif (substr($phone_number, 0, 1) == '7' || substr($phone_number, 0, 1) == '8' || substr($phone_number, 0, 1) == '9') {
                $phone_number = '234' . $phone_number;
            }
        }
        return $phone_number;
    }

    public static function phoneNumberFromDBFormat($phone_number)
    {
        if ($phone_number && substr($phone_number, 0, 3) == '234') {
            $phone_number = '0' . substr($phone_number, 3);
        }
        return $phone_number;
    }
}
