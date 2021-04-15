<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;

?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Edit Profile
@endsection

@section('content')
    
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Update Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Update Profile</li>
                </ol>
            </div>
        </div>
        
        <div class="container-fluid">

        @if(session('error'))
            <div class='alert alert-danger'>
                <i class="fa fa-remove"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class='alert alert-success'>
                <i class="fa fa-check"></i> {{ session('success') }}
            </div>
        @endif

        @php(Session::forget('success'))
        @php(Session::forget('error'))
        
    <div class="row" id="validation">
        <div class="col-md-12">
            <div class="card wizard-content">
                <div class="card-body">
                    <h4 class="card-title" align="center">Update Your  Profile</h4>

                    <form action="#" method="post" id="pregnant-nursing-women-wizard" class="tab-wizard wizard-circle" enctype="multipart/form-data">
                        <!-- Step 1 -->
                        {{csrf_field()}}
                        <h6>Personal Details</h6>
                        <section>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wfirstName2"> First Name : <span class="danger">*</span> </label>
                                        <input type="text" class="form-control required" id="wfirstName2" name="firstname" value="{{$the_user->firstname}}"> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wlastName2"> Last Name : <span class="danger">*</span> </label>
                                        <input type="text" class="form-control required" id="wlastName2" name="lastname" value="{{$the_user->lastname}}"> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wphoneNumber2">Phone Number :</label>
                                        <input type="tel" name="phone" class="form-control" id="wphoneNumber2" value="{{$the_user->phone}}"> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wdate2">Date of Birth :</label>
                                        <input type="date" class="form-control" name="dob" id="wdate2"  value="{{$the_user->dob}}"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wlocation2"> Select State: <span class="danger">*</span> </label>
                                        {!! Misc::selectedState($the_user->state) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="local_govts_div">
                                        {!! Misc::selectedLocalGovt($the_user->local_govt,$the_user->state) !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Home Address</label>
                                        <textarea name="home_address" class="form-control" rows="3">{{$the_user->address}}</textarea> 
                                    </div>
                                </div>
                                
                            </div>
                        </section>
                        <!-- Step 2 -->
                        
                        @if($the_user->user_type == "pregnant-woman")
                            <h6>Health & Pregnancy Details</h6>
                            <section>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="jobTitle2">Pregnancy Status</label>
                                            {!! Misc::selectedPregStatus($the_user->preg_status) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label> Pregnancy experience so far </label><br/>
                                        <textarea name="preg_experience" class="form-control" rows="5">{{$the_user->preg_experience}}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label> Your health history </label><br/>
                                        <textarea name="health_history" class="form-control" rows="5">{{$the_user->health_history}}</textarea>
                                    </div>
                                </div> <br/>
                            </section>
                        @endif
                        <!-- Step 3 -->
                        <h6>Other Details</h6>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wint1">Current Job Status</label>
                                       {!! Misc::selectedJobStatus($the_user->job_status) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wint1">How did you hear about us</label>
                                       {!! Misc::selectedHearAboutTypes($the_user->hear_about) !!}
                                    </div>
                                </div>
                            </div> <br/>
                        </section>
                    </form>

                    <div id="update-profile-status" align="center"></div>
                </div>
            
            </div>
            <br/><br/><br/><br/>
        </div>
    </div>
            
    @include('pregnant-nursing-women.footer')
    
@endsection
