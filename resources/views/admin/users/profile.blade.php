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
    
    @php($user_profile = Query::getFullname('users',$user_id))

    Natalpro | {{$user_profile}}'s Profile
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">{{$user_profile}}'s Profile</h3>
            </div>
        </div>
        
        <div class="container-fluid">
        <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>

        <h2 class="add-ct-btn pull-right"><button onclick="return userChats('{{$the_user->user_type}}','{{$the_user->id}}')" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-comments"></i> View chats </button></h2>

        <div style="clear:both;"></div>

            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30"> 
                                @if($the_user->pix == "")
                                    <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:150px;max-height:150px"/>
                                @else
                                    <img src="{{ asset('/storage/users/'.$the_user->pix) }}" class="img-responsive img-circle" style="max-width:150px;max-height:150px"/>
                                @endif
                                <p></p>
                                <h4 class="card-title m-t-10">{{Query::getFullname('users',$user_id)}}</h4>
                            </center>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Details </a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal" role="tabpanel">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">{{$the_user->email}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Phone no</strong>
                                            <br>
                                            <p class="text-muted">{{$the_user->phone}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Date of birth</strong>
                                            <br>
                                            <p class="text-muted">{!! Dates::formatTheDate($the_user->dob, "three") !!}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-12 b-r"> <strong>Location</strong>
                                            <br>
                                            <p class="text-muted">
                                                {!! Query::getValue('local_govts','id', $the_user->local_govt,'name') !!} , {!! Query::getValue('states','id', $the_user->state,'name')  !!} </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>Home address</strong>
                                            <br>
                                            <p class="text-muted">{{$the_user->address}}</p>
                                        </div>
                                    </div>

                                    <br/><h4> Health & Pregnancy Details </h4><hr/>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>Pregnancy status</strong>
                                            <br>
                                            <p class="text-muted">{{$the_user->preg_status}} months</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>Pregnancy experience </strong>
                                            <br>
                                            <p class="text-muted">{{ucfirst($the_user->preg_experience)}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>Health history</strong>
                                            <br>
                                            <p class="text-muted">{{ucfirst($the_user->health_history)}}</p>
                                        </div>
                                    </div>

                                    <br/><h4> Other Details </h4><hr/>
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>Current job status</strong>
                                            <br>
                                            <p class="text-muted">{{ucfirst($the_user->job_status)}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 b-r"> <strong>How you hear about us</strong>
                                            <br>
                                            <p class="text-muted">{{ucfirst($the_user->hear_about)}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>
    </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
