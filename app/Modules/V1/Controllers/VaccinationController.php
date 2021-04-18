<?php

namespace App\Modules\V1\Controllers;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VaccinationController extends Controller
{
    protected $vaccinationRepository;
    protected $request;

    public function __construct(Request $request, VaccinationRepository $vaccinationRepository)
    {
        $this->request = $request;
        $this->vaccinationRepository = $vaccinationRepository;
    }

    public function index()
    {
        $response = $this->vaccinationRepository->index();
        return redirect()->route('admin.vaccination.index')->with($response);
    }

    public function show($id)
    {
        $response = $this->vaccinationRepository->show($id);
        return redirect()->route('admin.vaccination.show')->with($response);
    }

    public function add()
    {
        $languages = ['english', 'yoruba', 'igbo', 'hausa'];
        $genders = ['male', 'female'];
        
        $data = [
            'languages' => $languages,
            'genders' => $genders
        ];

        return view('user.vaccination.add', $data);
    }

    public function request()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_number' => 'required|string',
                'mother' => 'required|string',
                'child' => 'required|string',
                'dob' => 'required|string',
                'gender' => 'required|string',
                'language' => 'required|string'
            ],
            [
                'first_name.required' => 'First name is required',
                'last_name.required' => 'Last name is required',
                'phone_number.required' => 'Phone number is required',
                'mother.required' => 'Mother\'s name is required',
                'child.required' => 'Child\'s name is required',
                'dob.required' => 'Child\'s date of birth is required',
                'language.required' => 'Kindly select the language you want SMS to be sent with',
                'gender.required' => 'Child\'s gender is required'
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

        $response = $this->vaccinationRepository->request($body);
        return $response;
    }
}
