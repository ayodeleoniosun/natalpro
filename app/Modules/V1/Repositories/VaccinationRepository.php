<?php

namespace App\Modules\V1\Repositories;

interface VaccinationRepository
{
    public function index();

    public function show(int $id);

    public function callback(int $transaction_id, string $reference_id);

    public function smsSamples();

    public function viewSmsSamples(string $interval);

    public function request(array $data);
}
