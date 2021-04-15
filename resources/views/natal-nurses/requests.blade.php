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

@extends('natal-nurses.pusher-app')

@section('title')
    Natalpro | Natal Nurses | My Requests
@endsection

@section('content')
    
    @php($fullname = Query::getFullname('users',$user_id))

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Home Service Requests</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Home Service Requests</li>
                </ol>
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

                        
                    @if($count_nurse_requests == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No home service request yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Fullname</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($nurse_requests as $key=>$request)

                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{$request->req_id}}</td>
                                            <td>{{ucwords($request->fullname)}}</td>
                                            <td>{{$request->phone}}</td>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('natal-nurses.footer')
    </div>
</div>
    
@endsection
