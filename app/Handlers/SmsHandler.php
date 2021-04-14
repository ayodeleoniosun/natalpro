<?php

namespace App\Handlers;

class SmsHandler
{
    public const BASE_URL = 'https://smartsmssolutions.com/api/json.php?';
    public const SENDER_NAME = 'NatalPro';
    public const ROUTING = 4;
    public const TYPE = 0;
    public const TOKEN = 'qczmEvQOju2v3MDuEIrAHclCG3om1WMN43rJJZPoMjjxZnyre0avGUwEWh8OWora18t1wghhIdZLL2oQEL4zKcqATTnwZBTCBW6Z';
    public const SUCCESS_CODE = 1000;

    public static function SendSms($recipient, $message)
    {
        $client = new \GuzzleHttp\Client();
        $url = self::BASE_URL.'message='.urlencode($message).'&to='.$recipient.'&sender='.self::SENDER_NAME.'&type='.self::TYPE.'&routing='.self::ROUTING.'&token='.self::TOKEN;
        
        $response = $client->request('GET', $url);
        $body = $response->getBody();
        $str = $body->getContents();
        $content = "$str";
        $decode_response = json_decode($content, true);
        
        // while ($decode_response['code'] != self::SUCCESS_CODE) {
        //     self::SendSms($recipient, $message);
        // }

        return ($decode_response['code'] == self::SUCCESS_CODE) ? 1 : 2;
    }
}
