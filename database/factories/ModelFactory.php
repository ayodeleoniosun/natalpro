<?php

use App\Modules\ApiUtility;
use App\Modules\V1\Models\User;

$factory->define(
    User::class,
    function (Faker\Generator $faker) {
        return [
            'email_address' => $faker->email,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => '080'.rand(111111111, 999999999),
            'password' => bcrypt('secret'),
            'bearer_token' => ApiUtility::generate_bearer_token(),
            'token_expires_at' => ApiUtility::next_one_month()
        ];
    }
);
