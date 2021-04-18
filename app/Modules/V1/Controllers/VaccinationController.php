<?php

namespace App\Modules\V1\Controllers;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Models\VaccinationCycle;
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
        return view('admin.vaccination.index', ['vaccinations' => $this->vaccinationRepository->index()]);
    }

    public function show($id)
    {
        $response = $this->vaccinationRepository->show($id);
        
        if ($response['status'] == 'error') {
            return redirect()->route('admin.vaccination.index')->with('alert-danger', $response['message']);
        }

        return view('admin.vaccination.show', $response);
    }

    public function add()
    {
        return view('user.vaccination.add', [
            'languages' => [
                'english', 'yoruba', 'igbo', 'hausa'
            ],
            
            'genders' => ['male', 'female']
        ]);
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

        return $this->vaccinationRepository->request($body);
    }

    public function smsSamples()
    {
        return view('admin.vaccination.sms-samples.index', $this->vaccinationRepository->smsSamples());
    }

    public function viewSmsSamples($interval)
    {
        return view('admin.vaccination.sms-samples.show', $this->vaccinationRepository->viewSmsSamples($interval));
    }
}
