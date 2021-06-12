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
                'phone_number' => 'required|string|unique:user,phone_number|min:10|max:15'
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
                'new_password' => 'required|string|min:6|different:current_password',
                'new_password_confirmation' => 'required|string|same:new_password',
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
