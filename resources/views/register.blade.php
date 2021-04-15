<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
use URL;

?>

@extends('login_app')

@section('title')
    Natalpro | Sign Up
@endsection

@section('content')
    <section id="wrapper" style="margin-top:-30px">
        <div class="login-register" style="background-image:url(../portal/assets/images/background/login-register.jpg);">
            <div style="margin:0px">
                <div class="card-body">

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
                    
                    <div align="center">
                        <a href="http://www.natalpro.org">
                            <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" class="img-responsive img-thumbnail" style="width:100px"/>
                        </a>
                    </div>
                    <br/>


                <div class="row" id="validation">
                    <div class="col-12">
                        <div class="card wizard-content">
                            <div class="card-body">
                                <h2 class="card-title" align="center">Become a natalpro member in less than 3 minutes!</h2>

                                <form action="#" id="reg-form" method="post" onsubmit="return false" enctype="multipart/form-data">
                                    <!-- Step 1 -->
                                    {{csrf_field()}}
                                    <div id="step_one">
                                        <h3 class="natal-heading" style="padding:10px">Personal Details</h4> <br/>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> Register as </label> <br/>
                                                <select name="user_type" id="user_type" class="form-control">
                                                    <option value=""> -- Select user type -- </option>
                                                    <option value="pregnant-woman"> Pregnant woman </option>
                                                    <option value="nursing-mother"> Nursing mother </option>
                                                    <option value="natal-nurse"> Healthcare professional </option>
                                                </select>

                                            </div>
                                            
                                            <div class="col-md-6">
                                                <br/>
                                                <div class="form-group ">
                                                    <label> Select profile picture  <small>(Optional)</small></label><br/>
                                                    <input type="file" name="pix" id="photo" accept=".jpg,.png,.JPEG,jpeg,PNG,JPG"/> 
                                                </div>
                                                <div id="preview_div" style="display:none">
                                                    <img src="#" id="preview_pix" style="width:100px" class="img-responsive"/> <br/><br/>
                                                </div> 
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wfirstName2"> First Name : <span class="danger">*</span> </label>
                                                    <input type="text" class="form-control required" id="wfirstName2" name="firstname"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlastName2"> Last Name : <span class="danger">*</span> </label>
                                                    <input type="text" class="form-control required" id="wlastName2" name="lastname"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wemailAddress2"> Email Address : <span class="danger">*</span> </label>
                                                    <input type="email" class="form-control required" id="wemailAddress2" name="email"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wphoneNumber2">Phone Number :</label>
                                                    <input type="tel" name="phone" class="form-control" id="wphoneNumber2"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wlocation2"> Select State: <span class="danger">*</span> </label>
                                                    {!! Misc::getStates() !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group" id="local_govts_div"></div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wdate2">Date of Birth :</label>
                                                    <input type="date" class="form-control" name="dob" id="wdate2"> 
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Home Address</label>
                                                    <textarea name="home_address" class="form-control" rows="3"></textarea> 
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <button type="button" id="normal_continue_btn" onclick="return theNextBtn('#step_one', '#step_two')" class="btn btn-info pull-right" style="background-color:#31516E;border:1px solid #31516E"> Continue <i class="fa fa-arrow-circle-right"></i> </button>

                                        <button type="button" id="hidden_continue_btn" style="display:none;background-color:#31516E;border:1px solid #31516E" onclick="return theNextBtn('#step_one', '#step_three')" class="btn btn-info pull-right"> Continue <i class="fa fa-arrow-circle-right"></i> </button>
                                        
                                    </div>

                                    <div id="step_two" style="display:none">
                                        <h3 class="natal-heading" style="padding:10px">Health & Pregnancy Details</h3> <br/>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="jobTitle2">Pregnancy Status</label>
                                                        {!! Misc::pregStatus() !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label> Pregnancy experience so far </label><br/>
                                                    <textarea name="preg_experience" class="form-control" rows="5"></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label> Your health history </label><br/>
                                                    <textarea name="health_history" class="form-control" rows="5"></textarea>
                                                </div>
                                            </div> <br/>
                                        </section>

                                        <button type="button" onclick="return PrevBtn('#step_two', '#step_one')" class="btn btn-info pull-left" style="background-color:#31516E;border:1px solid #31516E"><i class="fa fa-arrow-circle-left"></i> Prev </button>
                                        
                                        <button type="button" onclick="return NextBtn('#step_two', '#step_three')" class="btn btn-info pull-right" style="background-color:#31516E;border:1px solid #31516E"> Continue <i class="fa fa-arrow-circle-right"></i> </button>
                                        
                                    </div>

                                    <div id="step_three" style="display:none">
                                        <h3 class="natal-heading" style="padding:10px">Other Details</h3> <br/>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wint1">Current Job Status</label>
                                                       {!! Misc::jobStatus() !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="wint1">How did you hear about us</label>
                                                       {!! Misc::hearAboutTypes() !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label> Password <span class="danger">*</span> </label>
                                                        <input type="password" class="form-control required" name="password"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label> Confirm Password <span class="danger">*</span> </label>
                                                        <input type="password" class="form-control required" name="password_confirmation"> </div>
                                                </div>
                                            </div> <br/>
                                        </section>

                                        <button type="button" id="normal_prev_btn" style="background-color:#31516E;border:1px solid #31516E" onclick="return PrevBtn('#step_three', '#step_two')" class="btn btn-info pull-left"><i class="fa fa-arrow-circle-left"></i> Prev </button>
                                        
                                         <button type="button" id="hidden_prev_btn" style="display:none;background-color:#31516E;border:1px solid #31516E" onclick="return PrevBtn('#step_three', '#step_one')" class="btn btn-info pull-left"><i class="fa fa-arrow-circle-left"></i> Prev </button>

                                        <button type="submit" class="btn btn-info pull-right" id="reg-btn" onclick="return ajaxFormRequest('#reg-btn','#reg-form','/portal/sign-up','POST','#reg-status','Sign Up!','yes')" style="background-color:#31516E;border:1px solid #31516E">Sign Up!</button> <br/>

                                    </div>
                                </form>
                                <div style="clear:both"></div>
                                <div id="reg-status" align="center"></div>
                            </div>
                            <div style="clear:both"></div>
                                <div class="form-group m-b-0">
                                    <div class="col-sm-12 text-center">
                                        <p>Already have an account? <a href="{{ route('Login') }}" class="text-info m-l-5"><b>Sign In</b></a></p>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <br/><br/><br/><br/>
                    </div>
                </div>
                
            </div>
        </div>
    </section>


@endsection
