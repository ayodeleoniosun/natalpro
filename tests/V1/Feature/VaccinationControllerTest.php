<?php

namespace Tests\V1\Feature;

use Tests\V1\Traits\User as TraitsUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\V1\TestCase;

class VaccinationControllerTest extends TestCase
{
    use TraitsUser;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testRequiredDetailsPresentInVaccinationRequest()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => '',
            'mother' => 'Mummy Christy',
            'child' => 'christy',
            'dob' => '2021-04-12',
            'gender' => 'male',
            'amount' => '2000'
        ];

        $this->call('POST', $this->route('/vaccination/request'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('vaccination.add'))
            ->assertSessionHas('alert-danger', 'Phone number is required');
    }

    public function testVaccinationRequestSuccessful()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => '08132016744',
            'mother' => 'Mummy Christy',
            'child' => 'christy',
            'dob' => '2021-04-12',
            'gender' => 'male',
            'amount' => '2000'
        ];

        $response = $this->json('POST', $this->route('/vaccination/request'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('vaccination.add'))
            ->assertSessionHas('alert-success', 'Vaccination request successfully added.');
    }
}
