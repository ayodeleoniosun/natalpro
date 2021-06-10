<?php

namespace App\Modules\V1\Controllers;

use App\Modules\ApiUtility;
use App\Modules\V1\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userRepository;
    protected $request;

    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        $response = $this->userRepository->signIn($this->request->all());

        if ($response['status'] === 'success') {
            return redirect()->route('user.vaccination.index', ['userType' => 'user']);
        }
    
        return redirect()->route('user.index')->with('alert-danger', $response['message']);
    }

    public function users(string $type = null)
    {
        $response = $this->userRepository->users($type);
        $users = ['users' => $response];
        return view('admin.users.index', $users);
    }
    
    public function signUp()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email_address' => 'required|email|string',
                'password' => 'required|string|min:6',
                'phone_number' => 'required|string|min:10|max:15'
            ],
            [
                'first_name.required' => 'Firstname is required',
                'last_name.required' => 'Lastname is required',
                'email_address.required' => 'Email address is required',
                'password.required' => 'Password is required',
                'phone_number.required' => 'Phone number is required',
                'phone_number.min' => 'Phone number should be a minium of 10 characters',
                'phone_number.max' => 'Phone number should be a maximum of 15 characters',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $validation_errors = [
                    'status' => 'error',
                    'label' => 'danger',
                    'message' => $error
                ];
            }
        
            if (count($validation_errors) > 0) {
                return $validation_errors;
            }
        }
    
        return $this->userRepository->signUp($body);
    }

    public function userProfile(int $id)
    {
        $response =  $this->userRepository->profile($id);
        $user = ['user' => $response];
        return view('admin.users.show', $user);
    }

    public function changePassword()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
                'new_password_confirmation' => 'required|string|min:6|same:new_password',
            ],
            [
                'current_password.required' => 'Current password is required',
                'new_password.required' => 'New password is required',
                'new_password_confirmation.required' => 'Retype the new password',
                'new_password.min' => 'New password should be a minimum of 6 characters',
                'phone_number.same' => 'New password must be the same with new password confirmation',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $response = $this->userRepository->changePassword($body);

        if ($response['status'] === 'error') {
            return redirect()->back()->withInput()->with('alert-danger', $response['message']);
        }

        $this->request->session()->forget('user');
        return redirect()->route('user.index')->with('alert-success', $response['message']);
    }

    public function logout()
    {
        $this->request->session()->forget('user');
        return redirect()->route('user.index');
    }
}
