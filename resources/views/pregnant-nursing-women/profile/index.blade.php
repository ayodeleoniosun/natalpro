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
    Natalpro | My Profile
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">My Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
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
            
        <h2 class="add-ct-btn pull-right"><a href="{{ route('PregNursingWomenEditProfile') }}" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-pencil"></i> Edit Profile</a></h2>
        <div style="clear:both;"></div> <br/>

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

                                <h2 class="add-ct-btn"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#updatePixModal" data-whatever="@mdo"><i class="mdi mdi-camera"></i> Change profile picture</button></h2>
                                
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

                                    @if($the_user->user_type == "pregnant-woman")
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
                                    @endif
                                    
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

    <div class="modal fade" id="updatePixModal" tabindex="-1" role="dialog" aria-labelledby="updatePixModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="updatePixModalLabel1">Update Profile Picture</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-material" id="update_pix_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group ">
                            <label> Select profile picture </label><br/>
                            <input type="file" name="pix" id="photo" required="" accept=".jpg,.png,.JPEG,jpeg,PNG,JPG"/> 
                        </div>
                        <div id="preview_div" style="display:none" align="center">
                            <img src="#" id="preview_pix" style="width:150px"  class="img-responsive"/>
                        </div>

                        <div class="modal-footer" style="border:0px">
                            <div id="update_pix_status"></div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             <button type="button" id="update_pix_btn" onclick="return ajaxFormRequest('#update_pix_btn','#update_pix_form','/portal/pregnant-nursing-women/update-pix','POST','#update_pix_status','Change','yes')" class="btn btn-info"><i class="fa fa-check"></i> Change </button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>

    @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
