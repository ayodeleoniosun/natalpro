<?php

namespace App\Modules\V1\Repositories;

interface UserRepository
{
    public function users(string $data = null);

    public function signUp(array $data);

    public function signIn(array $data);

    public function profile(int $id);

    public function changePassword(array $data);

    public function updateProfilePicture(array $data);
}
