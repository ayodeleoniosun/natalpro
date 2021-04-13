<?php

namespace App\Modules\V1\Repositories;

interface VaccinationRepository
{
    public function index();

    public function request(array $data);
}
