<?php

namespace App\Modules\V1\Services;

use App\Modules\ApiUtility;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\User;
use App\Modules\V1\Models\UserToNatalType;
use App\Modules\V1\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserRepository
{
    public function users(string $type = null)
    {
        $natal_type = ($type && in_array($type, UserToNatalType::USER_TYPES)) ? (array) $type : UserToNatalType::USER_TYPES;

        $users = User::where('user.active_status', ActiveStatus::ACTIVE)
        ->join('user_to_natal_type', function ($join) use ($natal_type) {
            $join->on('user.id', '=', 'user_to_natal_type.user_id')
            ->whereIn('type', $natal_type);
        })->orderBy('user.id', 'DESC')->get();

        return $users->map(function ($user) {
            return (object) User::resource($user);
        });
    }

    public function signUp(array $data, string $user_type = null)
    {
        DB::beginTransaction();

        $user = User::create([
            'first_name' => strtolower($data['first_name']),
            'last_name' => strtolower($data['last_name']),
            'phone_number' => ApiUtility::phoneNumberToDBFormat($data['phone_number']),
            'email_address' => strtolower($data['email_address']),
            'is_email_generated' => $data['is_email_generated'],
            'password' => bcrypt($data['password']),
            'bearer_token' => ApiUtility::generate_bearer_token(),
            'token_expires_at' => ApiUtility::next_one_month(),
        ]);

        if ($user_type && in_array($user_type, UserToNatalType::USER_TYPES)) {
            UserToNatalType::create([
                'type' => $user_type,
                'user_id' => $user->id
            ]);
        }

        DB::commit();

        return $user;
    }

    public function signIn(array $data)
    {
        $user = User::validateUserCredentials($data['username'], $data['password']);
        
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Incorrect login details'
            ];
        }

        session(['user' => $user]);

        return [
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user
        ];
    }

    public function profile(int $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }

        return (object) User::resource($user);
    }

    public function changePassword(array $data)
    {
        $user = $data['auth_user'];
        $current_password = $data['current_password'];
        $new_password = $data['new_password'];
        
        if (!Hash::check($current_password, $user->password)) {
            return [
                'status' => 'error',
                'label' => 'danger',
                'message' => 'Incorrect current password',
            ];
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return [
            'status' => 'success',
            'label' => 'success',
            'message' => 'Password successfully changed. Kindly login again.',
        ];
    }
}
