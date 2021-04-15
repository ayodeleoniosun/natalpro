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
@extends('admin.app')

@section('title')
    Natalpro | All Vaccination Reminder Requests
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
            
            <div class="card">
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
                    

                    <div style="clear:both;"></div>

                    @if($count_vac_requests == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No vaccination reminder request yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Requested By</th>
                                        <th>Mother's name</th>
                                        <th>Child</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Date of birth</th>
                                        <th>Next reminder</th>
                                        <th>Requested On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($vac_requests as $key=>$request)
                                        
                                        @php($user_fullname = Query::getFullname('users', $request->users_id))
                                        
                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td><a href="{{$current_url}}/reminders/{{$request->id}}"><b> {{$request->req_id}} </b></a></td>
                                            <td><a href="{{$current_url}}/user/{{$request->users_id}}" class="text-info"> {{$user_fullname}} </a></td>
                                            <td>{{ucwords($request->mother)}}</td>
                                            <td>{{ucwords($request->child)}}</td>
                                            <td><a href="tel:{{$request->phone}}">{{$request->phone}}</a></td>
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
                                            <td>
                                                @if($request->status == "pending")  
                                                    <a href="{{$current_url}}/approve/{{$request->id}}" onclick="return confirm('Approve request?')"><i class="fa fa-check"></i></a> &nbsp; &nbsp;

                                                    <a href="{{$current_url}}/decline/{{$request->id}}" onclick="return confirm('Decline request?')" class="text-danger"><i class="fa fa-thumbs-down"></i></a> &nbsp; &nbsp;

                                                @elseif($request->status == "declined" || $request->status == "unpaid")  
                                                    <a href="{{$current_url}}/approve/{{$request->id}}" onclick="return confirm('Approve request?')"><i class="fa fa-check"></i></a> &nbsp; &nbsp;

                                                @elseif($request->status == "active")  
                                                    <a href="{{$current_url}}/decline/{{$request->id}}" onclick="return confirm('Decline request?')" class="text-danger"><i class="fa fa-thumbs-down"></i></a> &nbsp; &nbsp;
                                                @endif   
                                                <a href="{{$current_url}}/delete/{{$request->id}}" onclick="return confirm('Delete request?')" class="text-danger"><i class="fa fa-trash"></i></a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br/><div class="pull-right"> {{$vac_requests->links()}} </div>
                        <br/>
                    @endif
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
