<?php

namespace App\Modules\V1\Controllers;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Modules\ApiUtility;
use App\Modules\V1\Models\VaccinationCycle;
use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function index($user_type)
    {
        $body = $this->request->all();
        $body['user_type'] = $user_type;

        $response = $this->vaccinationRepository->index($body);
        
        if ($user_type === 'admin') {
            return view('admin.vaccination.index', ['vaccinations' => $response]);
        } else {
            return view('user.vaccination.index', ['vaccinations' => $response]);
        }
    }

    public function show($user_type, $id)
    {
        $body = $this->request->all();
        $body['user_type'] = $user_type;
        $body['id'] = $id;

        $error_route = $user_type === 'admin' ? 'admin.vaccination.index' : 'user.vaccination.index';
        $success_route = $user_type === 'admin' ? 'admin.vaccination.show' : 'user.vaccination.show';

        $response = $this->vaccinationRepository->show($body);
        
        if ($response['status'] == 'error') {
            return redirect()->route($error_route, ['userType' => $user_type])->with('alert-danger', $response['message']);
        }
        
        return view($success_route, $response);
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

    public function paymentSuccess()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'transaction_id' => 'required|string',
                'tx_ref' => 'required|string',
            ],
            [
                'transaction_id.required' => 'Transaction ID is required',
                'tx_ref.required' => 'Reference ID is required',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return redirect()->route('vaccination.add')->with('alert-danger', $error);
            }
        }

        $transaction_id = $this->request->input('transaction_id');
        $reference_id = $this->request->input('tx_ref');

        $response = $this->vaccinationRepository->callback($transaction_id, $reference_id);
        
        return redirect()->route('vaccination.add')->with('alert-'.$response['label'], $response['message']);
    }
    
    public function request()
    {
        $body = $this->request->all();
        
        $validator = Validator::make(
            $body,
            [
                'phone_number' => 'required|string',
                'mother' => 'required|string',
                'child' => 'required|string',
                'dob' => 'required|string',
                'gender' => 'required|string',
                'language' => 'required|string'
            ],
            [
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
                return redirect()->back()->withInput()->with('alert-danger', $error);
            }
        }

        $response = $this->vaccinationRepository->request($body);

        if ($response['status'] == 'error') {
            return redirect()->back()->withInput()->with('alert-danger', $response['message']);
        }

        return redirect()->away($response['payment_link']);
    }

    public function optOut($id)
    {
        $body = $this->request->all();
        $body['id'] = $id;

        $response = $this->vaccinationRepository->optOut($body);

        return redirect()->route('user.vaccination.index', ['userType' => 'user'])
            ->with('alert-'.$response['label'], $response['message']);
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
