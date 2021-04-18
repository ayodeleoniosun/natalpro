<?php

namespace App\Modules\V1\Repositories;

interface AdminRepository
{
    public function dashboard();

    public function settings();

    public function updateSettings(array $data);

    public function signIn(array $data);
}
