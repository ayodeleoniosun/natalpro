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
    Natalpro | Pregnant and Nursing Women | Home Service Nurses
@endsection

@section('content')
    
    @php($fullname = Query::getFullname('users',$user_id))

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-7 align-self-center">
                <h3 class="text-themecolor">Home Service Nurses <span class="badge badge-info">{{$count_nurse_requests}} </span></h3>
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

                    <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#nurseFormModal" data-whatever="@mdo"><i class="mdi mdi-medical-bag"></i> Request new nurse</button></h2>
                <div style="clear:both;"></div>
                     <br/>
                    
            <div class="card">
                <div class="card-body">

                    <div class="">

                        <div class="modal fade" id="nurseFormModal" tabindex="-1" role="dialog" aria-labelledby="nurseFormModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Home Service Nurse Request Form</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="nurse_form" method="POST" onsubmit="return false">
                                            {{csrf_field()}}

                                            <div class="form-group">
                                                <label> Your details </label> <br/>
                                                {!! Misc::nurseRequestUserType() !!}
                                            </div>

                                            <div id="current_div" style="display:none">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Fullname</label>
                                                    <input type="text" class="form-control" name="current_fullname" value="{{$fullname}}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Phone number</label>
                                                    <input type="text" class="form-control" name="current_phone" value="{{$the_user->phone}}" readonly/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Location</label>
                                                    <textarea name="current_location" class="form-control" rows="3" readonly>{{$the_user->address}}</textarea>
                                                </div>
                                            </div>

                                            <div id="new_div" style="display:none">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Fullname</label>
                                                    <input type="text" class="form-control" name="fullname"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Phone number</label>
                                                    <input type="text" class="form-control" name="phone"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Location</label>
                                                    <textarea name="location" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer" style="border:0px">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="nurse_btn" onclick="return ajaxFormRequest('#nurse_btn','#nurse_form','/portal/pregnant-nursing-women/request-nurse','POST','#nurse_status','Submit','no')" class="btn btn-info">Submit </button>
                                            </div>
                                            <div style="clear:both"></div>
                                            <br/>
                                            <div id="nurse_status" align="center"></div>
                                            
                                        </form>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        
                    @if($count_nurse_requests == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No home service nurse request yet </div>
                    @else

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Assigned Nurse</th>
                                        <th>Fullname</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Requested on</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($nurse_requests as $key=>$request)

                                        @php($nurse_fullname = Query::getFullname('users',$request->nurse_id))

                                        <tr>
                                            <td>{{$key+=1}}</td>
                                            <td>{{$request->req_id}}</td>
                                            <td>
                                                @if($request->nurse_id != "" )
                                                    <a href="#" class="text-info"> {{ucwords($nurse_fullname)}} </a></td>
                                                @else
                                                    <p class="text-danger"> None </p>
                                                @endif
                                            </td>
                                            <td>{{ucwords($request->fullname)}}</td>
                                            <td>{{$request->phone}}</td>
                                            <td>{{ucfirst($request->location)}}</td>
                                            <td> {!! Dates::formatDate($request->created_at) !!} </td><td>
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

                        <br/>
                        <div class="pull-right"> {{$nurse_requests->links()}} </div> <br/>

                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
