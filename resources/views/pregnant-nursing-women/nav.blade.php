<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
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

@php($online = Query::renderUserStatus('online', $user_id))

@php($unread_messages = DB::select("SELECT distinct(`inbox_id`) FROM inbox_responses WHERE (`recipient` = $user_id AND `status` = 'pending')  ORDER BY `id` DESC "))

<div id="main-wrapper">
    
    <header class="topbar"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header" style="border-bottom:2px solid #ccc">
                <a class="navbar-brand" href="#">
                    <b>
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="img-responsive img-circle" style="max-width:40px"/>
                    </b>
                    <span> Natalpro </span> </a>
            </div> 

            <div class="navbar-collapse">

                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    
                    <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                            @if(count($unread_messages) > 0)
                                <span class="badge badge-notify">{{count($unread_messages)}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu mailbox scale-up-left" aria-labelledby="2">
                            <ul>
                                <li>
                                    @if(count($unread_messages) > 0)
                                        <div class="drop-title">You have {{count($unread_messages)}} new messages</div>
                                    @endif
                                </li>
                                <li>
                                    <div class="message-center">
                                        
                                        @if(count($unread_messages) > 0)

                                            @foreach($unread_messages as $unread)
                                                
                                                @php($response = Query::getLastValue('inbox_responses', 'inbox_id', $unread->inbox_id, 'response'))

                                                @php($responded_on = Query::getLastValue('inbox_responses', 'inbox_id', $unread->inbox_id, 'created_at'))

                                                @php($encode_message = Misc::encoder($unread->inbox_id))

                                                @php($subject = Query::getValue('inbox', 'id', $unread->inbox_id, 'subject'))

                                                <a href="/portal/pregnant-nursing-women/messages/view/{{$encode_message}}">
                                                    <div class="user-img"> <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <span class="mail-desc" style="font-size:14px;font-weight: bold">{{ucfirst($subject)}}</span>
                                                        <span class="mail-desc">{{$response}}</span> 
                                                        <span class="time">{!! Dates::formatDate($responded_on, "three") !!}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            <p class="text-danger" align="center" style="margin-top:20px"> You have no new message </p>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="{{ route('PregNursingMessages') }}"> <strong>View all messages</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($the_user->pix == "")
                                <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:30px;max-height:30px"/>
                            @else
                                <img src="{{ asset('storage/users/'.$the_user->pix) }}" class="img-responsive img-circle" style="max-width:30px;max-height:30px"/>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li><a href="{{ route('PregNursingWomenProfile') }}"><i class="ti-user"></i> My Profile</a></li>
                                <li><a href="{{ route('PregNursingWomenEditProfile') }}"><i class="ti-pencil"></i> Edit Profile</a></li>
                                <li><a href="#" data-toggle="modal" data-toggle="tooltip" title="Change password" data-target="#changePasswordModal"><i class="ti-key"></i> Change Password</a></li>
                                <li><a href="{{ route('PregNursingWomenLogout') }}" onclick="return confirm('Logout?')"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>
        </nav>
    </header>
    
    
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="">
            <!-- User profile -->
            <div class="user-profile">
                <br/>
                <div align="center">

                    @if($the_user->pix == "")
                        <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                    @else
                        <img src="{{ asset('storage/users/'.$the_user->pix) }}" class="img-responsive img-circle" style="max-width:100px;max-height:100px"/>
                    @endif
                <br/><br/>

                <h5 class="container" align="center"><b><a href="{{ route('PregNursingWomenProfile') }}" class="text-info"> {!! Query::getFullname('users', $user_id) !!} </a></b></h5> 
                <hr style="border-bottom:1px solid #ccc"/>

            </div>

            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li> <a class="waves-effect waves-dark" href="http://www.natalpro.org" aria-expanded="false" target="_blank"><i class="mdi mdi-home"></i><span class="hide-menu">Home</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('PregNursingWomenDashboard') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a></li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-medical-bag"></i><span class="hide-menu">Requests </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('PregVaccinationRequests') }}">Vaccination Reminders</a></li>
                            <li><a href="{{ route('PregNurseRequests') }}">Home Service Nurses</a></li>
                        </ul>
                    </li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('PregKitOrders') }}" aria-expanded="false"><i class="fa fa-shopping-bag"></i><span class="hide-menu">Kits Orders</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('PregNurseVacSms') }}" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Vaccination SMS</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('PregNursePayments') }}" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Payments</span></a></li>

                    @if($the_user->user_type == "pregnant-woman")
                        <li> <a class="waves-effect waves-dark" href="{{ route('PregNursingAnteNatals') }}" aria-expanded="false"><i class="fa fa-stethoscope"></i><span class="hide-menu">Antenatal Section</span></a></li>

                    @else
                        <li> <a class="waves-effect waves-dark" href="{{ route('PregNursingPostNatals') }}" aria-expanded="false"><i class="fa fa-child"></i><span class="hide-menu">Postnatal Section</span></a></li>
                    @endif
                    
                    <li> <a class="waves-effect waves-dark" href="{{ route('PregNursingChats') }}" aria-expanded="false"><i class="fa fa-comments-o"></i><span class="hide-menu">Chats with nurse</span></a></li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-wechat"></i><span class="hide-menu">General Forums </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('PregNursingForums') }}">All Posts</a></li>
                            <li><a href="{{ route('MyPosts') }}">My Posts</a></li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="changePasswordModalLabel1">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-material" id="change_password_form" method="POST" onsubmit="return false">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">New Password</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation">
                        </div>

                        <div class="modal-footer" style="border:0px">
                            <div id="change_password_status"></div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                             <button type="button" id="change_password_btn" onclick="return ajaxFormRequest('#change_password_btn','#change_password_form','/portal/pregnant-nursing-women/update-password','POST','#change_password_status','Change','no')" class="btn btn-info"><i class="fa fa-check"></i> Change </button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="feedbackModalLabel1">Rate Nurse <span id="nurse_fullname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="patient_feedback"></div>
                </div>    
            </div>
        </div>
    </div>
