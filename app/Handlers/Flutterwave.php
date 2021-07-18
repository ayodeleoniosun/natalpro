<?php

namespace App\Handlers;

use App\Modules\ApiUtility;
use App\Modules\V1\Models\Setting;
use App\Modules\V1\Models\User;
use GuzzleHttp\Client;

class Flutterwave
{
    protected $base_url;
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->base_url = 'https://api.flutterwave.com/v3/payments';
    }
    
    public function vaccinationPayment($user, $price, $transaction_ref)
    {
        if (empty(env('FLUTTERWAVE_SECRET_KEY'))) {
            return;
        }

        try {
            $response = $this->client->post($this->base_url, [
                'json' => [
                    'tx_ref' => $transaction_ref,
                    'amount' => $price,
                    'currency' => 'NGN',
                    'redirect_url' => env('VACCINATION_WEBHOOK_URL'),
                    'payment_options' => 'card',
                    'customer' => [
                        'email' => $user->email_address,
                        'phonenumber' => $user->phone_number,
                        'name' => ucwords($user->first_name." ".$user->last_name)
                    ],
                    'customizations' => [
                        'title' => env('APP_NAME'),
                        'description' => 'Payment for vaccination request',
                        'logo' => env('LOGO')
                    ]
                ],

                'headers' => [
                    'Authorization' => 'Bearer '.env('FLUTTERWAVE_SECRET_KEY')
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function verify($transaction_id)
    {
        if (empty(env('FLUTTERWAVE_SECRET_KEY'))) {
            return;
        }

        try {
            $ref_url = 'https://api.flutterwave.com/v3/transactions/'.$transaction_id.'/verify';

            $response = $this->client->get($ref_url, [
                'headers' => [
                    'Authorization' => 'Bearer '.env('FLUTTERWAVE_SECRET_KEY')
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e;
        }
    }
}
