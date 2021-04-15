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

@php($unread_messages = DB::select("SELECT distinct(`inbox`.`id`) FROM inbox LEFT JOIN inbox_responses ON `inbox`.`id` = `inbox_responses`.`inbox_id` WHERE (`inbox_responses`.`recipient` = 'admin' AND `inbox_responses`.`status` = 'pending') OR (`inbox`.`recipient` = 'admin' AND `inbox`.`status` = 'pending') ORDER BY `inbox`.`id` DESC"))

<div id="main-wrapper">
    
    <header class="topbar" style="background-color:#31516E"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header" style="border-bottom:2px solid #ccc">
                <a class="navbar-brand" href="#">
                    <b>
                        <img src="{{ URL::asset('assets/images/logo-icon.png')}}" alt="homepage" class="img-responsive img-circle" style="max-width:40px"/>
                    </b>
                    <span> NatalPro </span> </a>
            </div> 

            <div class="navbar-collapse">

                <ul class="navbar-nav mr-auto mt-md-0">
                    
                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    
                    <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

                    <li class="nav-item m-l-10"> <a href="{{ route('AdminSettings') }}" class="nav-link text-muted waves-effect waves-dark"  data-toggle="tooltip" title="Basic settings"><i class="mdi mdi-settings"></i></a> </li>

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
                                                
                                                @php($count_message = Query::countRows('inbox_responses', 'inbox_id', $unread->id))

                                                @if($count_message == 0)
                                                    
                                                    @php($responded_on = Query::getValue('inbox', 'id', $unread->id, 'created_at'))

                                                    @php($response = Query::getValue('inbox', 'id', $unread->id, 'message'))
                                                
                                                @else

                                                    @php($responded_on = Query::getLastValue('inbox_responses', 'inbox_id', $unread->id, 'created_at'))
                                                    
                                                    @php($response = Query::getLastValue('inbox_responses', 'inbox_id', $unread->id, 'response'))

                                                @endif

                                                @php($encode_message = Misc::encoder($unread->id))

                                                @php($subject = Query::getValue('inbox', 'id', $unread->id, 'subject'))

                                                <a href="/portal/controlling-room-admin/messages/view/{{$encode_message}}">
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
                                    <a class="nav-link text-center" href="{{ route('AdminMessages') }}"> <strong>View all messages</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>

                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ URL::asset('/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:30px;max-height:30px"/>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li><a href="#" data-toggle="modal" data-toggle="tooltip" title="Change password" data-target="#changePasswordModal"><i class="ti-key"></i> Change Password</a></li>
                                <li><a href="{{ route('AdminLogout') }}" onclick="return confirm('Logout?')"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                
            </div>
        </nav>
    </header>
    
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- User profile -->
            <div class="user-profile">
                <br/>
                <!-- <div align="center"> <img src="{{ URL::asset('images/uilogo.jpg') }}" class="img-responsive" style="width:80px"/> </div><br/> -->
                
                <!-- <div class="profile-text">
                    <a href="#" data-toggle="modal" data-toggle="tooltip" title="Change password" data-target="#changePasswordModal"><i class="mdi mdi-key"></i></a> &nbsp; &nbsp;
                    <a href="{{ route('AdminLogout') }}" onclick="return confirm('Logout?')" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                </div> -->
 
            </div>

            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li> <a class="waves-effect waves-dark" href="http://www.natalpro.org" aria-expanded="false" target="_blank"><i class="mdi mdi-home"></i><span class="hide-menu">Home</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('AdminDashboard') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a></li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-user-circle"></i><span class="hide-menu">Users </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('PregWomen') }}">Pregnant Women</a></li>
                            <li><a href="{{ route('NursingMothers') }}">Nursing Mothers</a></li>
                            <li><a href="{{ route('NatalNurses') }}">Healthcare Professionals</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-medical-bag"></i><span class="hide-menu">Requests </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('VaccinationRequests') }}">Vaccination Reminders</a></li>
                            <li><a href="{{ route('NurseRequests') }}">Home Service Healthcare Professionals</a></li>
                        </ul>
                    </li>

                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">Vaccination SMS </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('VaccinationSmsSamples') }}">SMS Samples</a></li>
                            <li><a href="{{ route('VaccinationSms') }}">Sent SMS</a></li>
                        </ul>
                    </li>
                    
                    <li> <a class="waves-effect waves-dark" href="{{ route('BulkSms') }}" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Bulk SMS</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('AdminKitOrders') }}" aria-expanded="false"><i class="fa fa-shopping-bag"></i><span class="hide-menu">Kits Orders</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('AdminPayments') }}" aria-expanded="false"><i class="fa fa-money"></i><span class="hide-menu">Payments</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('AnteNatals') }}" aria-expanded="false"><i class="fa fa-stethoscope"></i><span class="hide-menu">Antenatal Section</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('PostNatals') }}" aria-expanded="false"><i class="fa fa-child"></i><span class="hide-menu">Postnatal Section</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="{{ route('AllPosts') }}" aria-expanded="false"><i class="fa fa-wechat"></i><span class="hide-menu">General Forums</span></a></li>

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
                             <button type="button" id="change_password_btn" onclick="return ajaxFormRequest('#change_password_btn','#change_password_form','/portal/controlling-room-admin/change-password','POST','#change_password_status','Change','no')" class="btn btn-info"><i class="fa fa-check"></i> Change </button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
