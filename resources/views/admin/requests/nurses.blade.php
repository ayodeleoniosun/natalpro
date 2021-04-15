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
    Natalpro | All Healthcare Professionals Requests
@endsection

@section('content') 

    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Healthcare Professionals Requests  <span class="badge badge-info">{{$count_nurse_requests}} </span></h3>
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

                    
            <div class="card">
                <div class="card-body">

                    <div class="">

                        
                    @if($count_nurse_requests == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No nurse request yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Assigned Nurse</th>
                                        <th>Request By</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($nurse_requests as $key=>$request)

                                        @php($nurse_fullname = Query::getFullname('users', $request->nurse_id))

                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{$request->req_id}}</td>
                                            <td>
                                                @if($request->nurse_id != "" )
                                                    <a href="{{$current_url}}/user/{{$request->nurse_id}}" class="text-info"> {{ucwords($nurse_fullname)}} </a></td>
                                                @else
                                                    <p class="text-danger"> None </p>
                                                @endif
                                            <td><a href="{{$current_url}}/user/{{$request->users_id}}" class="text-info"> {{ucwords($request->fullname)}} </a></td>
                                            <td><a href="tel:{{$request->phone}}">{{$request->phone}}</a></td>
                                            <td>{{ucfirst($request->location)}}</td>
                                            <td>
                                                @if($request->status == "pending")  
                                                    <p style='color:brown'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @elseif($request->status == "approved")  
                                                    <p class='text-primary'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @elseif($request->status == "declined")  
                                                    <p class='text-danger'>    
                                                        {{ucfirst($request->status)}}
                                                    </p>
                                                @endif                                                
                                            </td>
                                            <td>
                                                @if($request->status == "pending")  
                                                    <a href="#" onclick="return nurseRequest('assign','{{$request->id}}')"><i class="fa fa-check"></i></a> &nbsp; &nbsp;
                                                    <a href="#" onclick="return nurseRequest('decline','{{$request->id}}')" class="text-danger"><i class="fa fa-thumbs-down"></i></a> &nbsp; &nbsp;
                                                @elseif($request->status == "declined")  
                                                    <a href="#" onclick="return nurseRequest('assign','{{$request->id}}')"><i class="fa fa-check"></i></a> &nbsp; &nbsp;
                                                @elseif($request->status == "approved")  
                                                    <a href="#" onclick="return nurseRequest('decline','{{$request->id}}')" class="text-danger"><i class="fa fa-thumbs-down"></i></a> &nbsp; &nbsp;
                                                @endif   
                                                <a href="{{$current_url}}/delete/{{$request->id}}" onclick="return confirm('Delete request?')" class="text-danger"><i class="fa fa-trash"></i></a>
                                                <div id="assign-status{{$request->id}}"></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            
                        <br/><div class="pull-right"> {{$nurse_requests->links()}} </div>
                        <br/>

                    @endif
                     <br/>
                </div>
            </div>
        </div>


        
@endsection
