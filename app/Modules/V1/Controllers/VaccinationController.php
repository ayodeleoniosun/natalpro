<?php

namespace App\Modules\V1\Controllers;

use App\Modules\V1\Repositories\VaccinationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('vaccination.add')->withErrors($validator);
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
                'phone_number' => 'required|string|unique:user,phone_number|between:10,15',
                'mother' => 'required|string',
                'child' => 'required|string',
                'dob' => 'required|string',
                'gender' => [
                    'required',
                    'string',
                    Rule::in(['male', 'female'])
                ],
                'language' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
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
