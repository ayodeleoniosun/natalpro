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
    Natalpro | Vaccination Reminders for {{$the_vaccination->req_id}} 
@endsection

@section('content') 

    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminders for  {{$the_vaccination->req_id}} <span class="badge badge-info">{{$count_vac_reminders}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">
            
            <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>
            <div style="clear:both;"></div>
            <br/>

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

            @if($count_vac_reminders == 0) 
                <div class="alert alert-danger" style="margin:0 auto"> No reminder yet </div>
            @else

                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Interval</th>
                                <th>Reminder Status</th>
                                <th>SMS</th>
                                <th>Sent on</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($vac_reminders as $key=>$reminder)
                                
                                @php($vac_req_id = Query::getValue('vaccination_requests', 'id', $reminder->vac_id, 'req_id'))

                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td> {{$reminder->recipient}} </td>
                                    <td> {{$reminder->email}} </td>
                                    <td>{!! Misc::selectedVacIntervals($reminder->vac_interval) !!}</td>
                                    <td> {{ucwords($reminder->reminder_interval)}} </td>
                                    <td> <button onclick="return smsRequest('view','{{$reminder->id}}')" class="btn btn-sm btn-info"> View </button>
                                        <div id="sms-status{{$reminder->id}}"></div>
                                    </td>
                                    <td> {!! Dates::formatDate($reminder->created_at, "three") !!}  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br/><div class="pull-right"> {{$vac_reminders->links()}} </div>
                <br/>
            @endif
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
