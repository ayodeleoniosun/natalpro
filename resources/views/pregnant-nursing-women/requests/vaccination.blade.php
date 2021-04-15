<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('pregnant-nursing-women.app')

@section('title')
    Natalpro | Pregnant and Nursing Women | Vaccination Reminder Requests
@endsection

@section('content')
    
    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminder Requests <span class="badge badge-info">{{$count_vac_requests}} </span></h3>
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

                    <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#vaccinationFormModal" data-whatever="@mdo"><i class="mdi mdi-medical-bag"></i> Request new vaccination reminder</button></h2>
                <div style="clear:both;"></div>
                     <br/>
                    
            <div class="card">
                <div class="card-body">

                    <div class="">

                        <div class="modal fade" id="vaccinationFormModal" tabindex="-1" role="dialog" aria-labelledby="vaccinationFormModalLabel1">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="addDeptAdminModalLabel1">Vaccination Reminder Form</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal form-material" id="vaccination_form" method="POST" onsubmit="return false">
                                            {{csrf_field()}}

                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Language</label>
                                                {!! Misc::selectLanguage() !!}
                                            </div>

                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Mother's name</label>
                                                <input type="text" class="form-control" name="mother"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Child's name</label>
                                                <input type="text" class="form-control" name="child"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Phone number (<small> This is where sms will be sent to per intervals</small>)</label>
                                                <input type="text" class="form-control" name="phone"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Email address (<small> For receiving mails as alternative to phone number</small>)</label>
                                                <input type="email" class="form-control" name="email"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Child's Date of birth</label>
                                                <input type="text" class="form-control" name="dob" placeholder="Select date" id="mdate"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Child's Gender</label>
                                                {!! Misc::selectGender() !!}
                                            </div>

                                            <div class="modal-footer" style="border:0px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="vaccination_btn" onclick="return ajaxFormRequest('#vaccination_btn','#vaccination_form','/portal/pregnant-nursing-women/request-vaccination','POST','#vaccination_status','Submit','no')" class="btn btn-info">Submit </button>
                                            </div>
                                            <div style="clear:both"></div>
                                            <br/>
                                            <div id="vaccination_status" align="center"></div>
                                            
                                        </form>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        
                    @if($count_vac_requests == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No vaccination reminder request yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Mother's name</th>
                                        <th>Child</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Date of birth</th>
                                        <th>Next Reminder</th>
                                        <th>Requested On</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($vac_requests as $key=>$request)
                                        
                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td><a href="{{$current_url}}/reminders/{{$request->id}}"><b> {{$request->req_id}} </b></a></td>
                                            <td>{{ucwords($request->mother)}}</td>
                                            <td>{{ucwords($request->child)}}</td>
                                            <td>{{$request->phone}}</td>
                                            <td>{{$request->email}}</td>
                                            <td>{{ucwords($request->sex)}}</td>
                                            <td>{!! Dates::formatDateOnly($request->dob, "three") !!}</td>
                                            <td>
                                                @if( $request->next_interval == "" || $request->next_schedule == "")
                                                    <p class='text-info'> At birth -  {!! Dates::formatDateOnly($request->dob, "three") !!} </p>
                                                @else
                                                    <p class='text-info'>
                                                        {!! Misc::selectedVacIntervals($request->next_interval) !!} time - 
                                                        {!! Dates::formatDateOnly($request->next_schedule, "three") !!} 
                                                    </p>
                                                @endif
                                            </td>
                                            <td>{!! Dates::formatDate($request->created_at) !!}</td>
                                            <td>
                                                @if($request->status == "pending")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @elseif($request->status == "active")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @elseif($request->status == "declined")  
                                                    <p class='text-danger'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @else 
                                                    <p class='text-danger'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br/>
                        <div class="pull-right"> {{$vac_requests->links()}} </div>
                        <br/>
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
