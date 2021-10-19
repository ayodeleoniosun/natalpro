<?php

namespace App\Handlers;

use Twilio\Rest\Client;

class SmsHandler
{
    protected $sid;
    protected $msg_id;
    protected $auth_token;
    protected $sender_name;

    public function __construct()
    {
        $this->sid = env('TWILIO_ACCOUNT_SID');
        $this->msg_id = env('TWILIO_MSG_ID');
        $this->auth_token = env('TWILIO_AUTH_TOKEN');
        $this->sender_name = env('SMS_SENDER_NAME');
    }
    
    public function SendSms($recipient, $message)
    {
        $twilio = new Client($this->sid, $this->auth_token);

        $message = $twilio->messages->create($recipient, [
            "from" => $this->sender_name,
            "body" => $message
        ]);
            
        return !$message->errorCode ? 'success' : 'failed';
    }
}
