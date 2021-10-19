<?php

namespace App\Handlers;

use App\Modules\ApiUtility;
use GuzzleHttp\Client;

class SmsHandler
{
    protected $username;
    protected $apiKey;
    protected $senderName;
    protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->username = env('SMS_USERNAME');
        $this->apiKey = env('SMS_API_KEY');
        $this->senderName = env('SMS_SENDER_NAME');
        $this->client = $client;
        $this->baseUrl = "http://api.ebulksms.com:8080/sendsms.json";
    }
    
    public function SendSms($recipient, $message)
    {
        $url = "http://api.ebulksms.com:80/sendsms?username=".$this->username."&apikey=".$this->apiKey."&sender=".$this->senderName."&messagetext=".$message."&flash=0&recipients=".$recipient;
        
        $response = $this->client->get($url);

        return $response;

        // if (empty(env('SMS_API_KEY'))) {
        //     return;
        // }

        // try {
        //     $response = $this->client->post($this->baseUrl, [
        //         'SMS' => [
        //             'auth' => [
        //                 'username' => $this->username,
        //                 'apikey' => $this->apiKey,
        //             ],
        //             'message' => [
        //                 'sender' => $this->senderName,
        //                 'messagetext' => $message,
        //                 "flash" => 0,
        //             ],
        //             'recipients' => [
        //                 "gsm" => [
        //                     'msidn' => $recipient,
        //                     'msgid' => uniqid(),
        //                 ],
        //             ],
        //             "dndsender" => 1
        //         ],

        //         'headers' => [
        //             'Content-Type' => 'application/json'
        //         ]
        //     ]);

        //     return json_decode($response->getBody()->getContents());
        // } catch (\Exception $e) {
        //     return $e;
        // }
    }
}
