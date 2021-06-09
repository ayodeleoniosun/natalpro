<?php

namespace App\Modules\V1\Services;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\File;
use App\Modules\V1\Models\User;
use App\Modules\V1\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService implements UserRepository
{
    public function users(string $type = null)
    {
        if (in_array($type, [User::USER_TYPES])) {
            $users = User::where([
                'type' => $type,
                'role_type' => 'user',
                'active_status' => ActiveStatus::ACTIVE
            ])->orderBy('id', 'DESC')->get();
        } else {
            $users = User::where([
                'role_type' => 'user',
                'active_status' => ActiveStatus::ACTIVE
            ])->orderBy('id', 'DESC')->get();
        }

        return $users->map(function ($user) {
            return (object) User::resource($user);
        });
    }

    public function signUp(array $data)
    {
        $user = new User();
        $user->first_name = strtolower($data['first_name']);
        $user->last_name = strtolower($data['last_name']);
        $user->phone_number = $data['phone_number'];
        $user->email_address = strtolower($data['email_address']);
        $user->is_email_generated = $data['is_email_generated'];
        $user->bearer_token = ApiUtility::generate_bearer_token();
        $user->token_expires_at = ApiUtility::next_one_month();
        $user->password = bcrypt($data['password']);
        $user->save();

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
            throw new CustomApiErrorResponseHandler("Incorrect current password.");
        }

        if ($current_password === $new_password) {
            throw new CustomApiErrorResponseHandler("Your new password should be different from your current password.");
        }
        
        $user->password = bcrypt($new_password);
        $user->save();

        return 'Your password was successfully updated.';
    }

    public function updateProfilePicture(array $data)
    {
        $user = $data['auth_user'];
        $picture = $data['picture'];
        $size = ceil($picture->getSize()/1024);
        
        if ($size > File::MAX_FILESIZE) {
            throw new CustomApiErrorResponseHandler("Picture should not be more than 5MB.");
        }

        $user_fullname = $data['auth_user']->first_name." ".$data['auth_user']->last_name;
        $timestamp = ApiUtility::generateTimeStamp();
        $filename = "{$timestamp}_{$user_fullname}";
        $filename = Str::slug($filename, "_");
        $profile_picture = "{$filename}.{$picture->clientExtension()}";

        Storage::disk('users')->put($profile_picture, file_get_contents($picture->getRealPath()));

        DB::beginTransaction();
        $file = new File();
        $file->filename = $filename;
        $file->type = File::USER_FILE_TYPE;
        $file->save();

        $user->file_id = $file->id;
        $user->save();
        
        DB::commit();

        return 'Your profile picture was successfully updated.';
    }
}
