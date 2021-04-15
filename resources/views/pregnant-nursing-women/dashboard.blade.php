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

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Pregnant and Nursing Women | Dashboard
@endsection

@section('content')
    
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
            </div>
        </div>
        
        <div class="container-fluid">
            <h3> Welcome back, {!! Query::getFullname('users', $user_id) !!}  </h3>
                <div style="clear:both"></div>
                <br/>
                
            <div class="row">
                <!-- Column -->
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('PregVaccinationRequests') }}">
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
                    <a href="{{ route('PregNurseRequests') }}">
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
                    <a href="{{ route('PregNursingAnteNatals') }}">
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
                    <a href="{{ route('PregNursingPostNatals') }}">
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

                <div style="clear:both"></div>
                
            </div>
            
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
