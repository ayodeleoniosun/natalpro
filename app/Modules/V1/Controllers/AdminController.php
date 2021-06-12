<?php

namespace App\Modules\V1\Controllers;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    protected $adminRepository;
    protected $request;

    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->request = $request;
        $this->adminRepository = $adminRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', $this->adminRepository->dashboard());
    }

    public function login()
    {
        $response = $this->adminRepository->signIn($this->request->all());
        
        if ($response['status'] === 'success') {
            return redirect()->route('admin.dashboard');
        }
        
        return back()->with('alert-danger', $response['message']);
    }

    public function settings()
    {
        return view('admin.settings', $this->adminRepository->settings());
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
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $response = $this->adminRepository->updateSettings($body);

        return redirect()->back()->withInput()->with('alert-'.$response['label'], $response['message']);
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

        $response = $this->adminRepository->updatePassword($body);

        if ($response['status'] === 'error') {
            return redirect()->back()->withInput()->with('alert-danger', $response['message']);
        }

        $this->request->session()->forget('admin');
        return redirect()->route('admin.index')->with('alert-success', $response['message']);
    }

    public function logout()
    {
        $this->request->session()->forget('admin');
        return redirect()->route('admin.index');
    }
}
