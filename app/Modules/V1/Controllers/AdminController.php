<?php

namespace App\Modules\V1\Controllers;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $adminRepository;
    protected $request;

    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->request = $request;
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return view('admin.index');
    }

    public function dashboard()
    {
        $response = $this->adminRepository->dashboard();
        return view('admin.dashboard', $response);
    }

    public function login()
    {
        $body = $this->request->all();
        $response = $this->adminRepository->signIn($body);
        return $response;
    }

    public function settings()
    {
        $response = $this->adminRepository->settings();
        return view('admin.settings', $response);
    }

    public function updateSettings()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'vaccination_amount' => 'required|string',
                'kit_amount' => 'required|string',
                'welcome_message' => 'required|string',
            ],
            [
                'vaccination_amount.required' => 'Vaccination amount is required',
                'kit_amount.required' => 'Kit amount is required',
                'welcome_message.required' => 'Welcome message is required'
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

        $response = $this->adminRepository->updateSettings($body);
        return $response;
    }

    public function changePassword()
    {
        ApiUtility::auth_user($this->request);
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
            throw new CustomApiErrorResponseHandler($validator->errors()->first());
        }

        return response()->json(['status' => 'success', 'data' => $this->userRepository->changePassword($body)], 200);
    }
}