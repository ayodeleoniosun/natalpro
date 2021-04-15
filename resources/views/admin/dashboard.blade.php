<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use URL;
use Session;
?>

@extends('admin.app')

@section('title')
    Natalpro | Admin | Dashboard
@endsection

@section('content')
    
    @php($current_url = \Request::url())
    @php($sms_balance = Misc::smsBalance())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
            </div>
        </div>
        
        <div style="margin:20px">
            <h2> Welcome back, Administrator  </h2>
            <small style="font-size:15px"> Your SMS Balance is <b> {!! Misc::smsBalance() !!} units </b>.
                
                @if(ceil($sms_balance) < 200)
                    Click <a href='https://smartsmssolutions.com/sms/buy-sms-online' target='_blank'><b>HERE</b></a> to top up your units to ensure the continuity of sms
                @endif
                <br/>
            <div style="clear:both"></div>
            <br/><br/>

            
            <div class="row">
                <!-- Column -->
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('VaccinationRequests') }}">
                        <div class="card btn btn-info">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#fff">{{$count_vac_requests}} </h2>
                                        <h6 style="color:#fff"> Vaccination Requests </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('NurseRequests') }}">
                        <div class="card btn btn-default">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#000">{{$count_nurse_requests}} </h2>
                                        <h6 style="color:#000"> Nurse Requests </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>

                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('AnteNatals') }}">
                        <div class="card btn btn-warning">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#fff">{{$count_antenatals}}</h2>
                                        <h6 style="color:#fff"> Antenatals</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('PostNatals') }}">
                        <div class="card btn btn-primary">
                            <div class="card-body">
                                <!-- Row -->
                                <div class="row">
                                    <div class="col-8">
                                        <h2 style="color:#fff">{{$count_postnatals}}</h2>
                                        <h6 style="color:#fff"> Postnatals</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>
            </div>

            <div class="row">
                <div class="container">

                    <div class="pull-right">
                        <br/>
                        @if(count($patients) > 0)
                            <a href="{{ route('PregWomen') }}" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"> View all patients <i class="fa fa-angle-right"></i></a>
                        @endif
                        <br/><br/>
                    </div>
                    <br/>

                    <h3 class="pull-left"> Recent Patients </h3> 
                    <br/>
                </div>

                @if(count($patients) == 0) 
                    <div class="container">
                        <div class="alert alert-danger"> No patient yet </div>
                    </div>
                @else

                
                    @foreach($patients as $patient)

                        @php($patient_fullname = Query::getFullname('users', $patient->id))

                        <div class="col-md-6 col-lg-6 col-xlg-4">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-md-4 col-lg-3 text-center">
                                        <a href="/portal/controlling-room-admin/pregnant-nursing-women/profile/{{$patient->id}}">
                                            @if($patient->pix == "")
                                                <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                                            @else
                                                <img src="{{ asset('storage/users/'.$patient->pix) }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-lg-9">
                                        <h3 class="box-title m-b-0">
                                            <a href="/portal/controlling-room-admin/pregnant-nursing-women/profile/{{$patient->id}}" class="text-info"> {{$patient_fullname}} </a>
                                        </h3> <p></p>
                                        <small> {{$patient->address}} </small>
                                            
                                        <br/> <p></p>
                                        
                                        <small> 
                                            <i class="fa fa-map-marker"></i> {!! Query::getValue('local_govts','id', $patient->local_govt,'name') !!} , {!! Query::getValue('states','id', $patient->state,'name')  !!}
                                        </small> <br/> <p></p>

                                        <small> 
                                            <a href="tel:{{$patient->phone}}"><i class="fa fa-phone"></i> {{$patient->phone}} </a> &nbsp; &nbsp; <a href="mailto:{{$patient->email}}"><i class="fa fa-envelope"></i> {{$patient->email}} </a>
                                        </small>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <br/><br/><br/>
                    
                @endif

            </div>

            <div class="row">
            
                <div class="container"> 
                    <div class="pull-right">
                        <br/>
                        @if(count($nurses) > 0)
                            <a href="{{ route('NatalNurses') }}" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"> View all nurses <i class="fa fa-angle-right"></i></a> 
                        @endif
                        <br/><br/>
                    </div>
                    <br/>
                    <h3 class="pull-left"> Recent Healthcare Professionals </h3> 
                    <br/>
                </div>

                @if(count($nurses) == 0) 
                    <div class="container">
                        <div class="alert alert-danger"> No healthcare professionals yet </div>
                    </div>
                @else

                    @foreach($nurses as $nurse)

                        @php($nurse_fullname = Query::getFullname('users', $nurse->id))

                        <div class="col-md-6 col-lg-6 col-xlg-4">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-md-4 col-lg-3 text-center">
                                        <a href="/portal/controlling-room-admin/natal-nurses/profile/{{$nurse->id}}">
                                            @if($nurse->pix == "")
                                                <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                                            @else
                                                <img src="{{ asset('storage/users/'.$nurse->pix) }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-lg-9">
                                        <h3 class="box-title m-b-0">
                                            <a href="/portal/controlling-room-admin/natal-nurses/profile/{{$nurse->id}}" class="text-info"> {{$nurse_fullname}} </a>
                                        </h3> <p></p>
                                        <small> {{$nurse->address}} </small>
                                            
                                        <br/> <p></p>
                                        
                                        <small> 
                                            <i class="fa fa-map-marker"></i> {!! Query::getValue('local_govts','id', $nurse->local_govt,'name') !!} , {!! Query::getValue('states','id', $nurse->state,'name')  !!}
                                        </small> <br/> <p></p>

                                        <small> 
                                            <a href="tel:{{$nurse->phone}}"><i class="fa fa-phone"></i> {{$nurse->phone}} </a> &nbsp; &nbsp; <a href="mailto:{{$nurse->email}}"><i class="fa fa-envelope"></i> {{$nurse->email}} </a>
                                        </small>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div style="clear:both"></div>
                    <br/>

                @endif

            </div>
            
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
