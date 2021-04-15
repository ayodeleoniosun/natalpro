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
    Natalpro | All Vaccination SMS
@endsection

@section('content') 

    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination SMS <span class="badge badge-info">{{$count_vac_sms}} </span></h3>
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

            @if($count_vac_sms == 0) 
                <div class="alert alert-danger" style="margin:0 auto"> No vaccination sms yet </div>
            @else

                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Vac. ID</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Interval</th>
                                <th>Reminder Status</th>
                                <th>SMS</th>
                                <th>Sent on</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($vac_sms as $key=>$sms)
                                
                                @php($vac_req_id = Query::getValue('vaccination_requests', 'id', $sms->vac_id, 'req_id'))

                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td> {{$vac_req_id}} </td>
                                    <td> {{$sms->recipient}} </td>
                                    <td> {{$sms->email}} </td>
                                    <td>{!! Misc::selectedVacIntervals($sms->vac_interval) !!}</td>
                                    <td> {{ucwords($sms->reminder_interval)}} </td>
                                    <td> <button onclick="return smsRequest('user-view','{{$sms->id}}')" class="btn btn-sm btn-info"> View </button>
                                        <div id="sms-status{{$sms->id}}"></div>
                                    </td>
                                    <td> {!! Dates::formatDate($sms->created_at, "three") !!}  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br/><div class="pull-right"> {{$vac_sms->links()}} </div>
                <br/>
            @endif
            </div>
        </div>

        @include('pregnant-nursing-women.footer')
    </div>
</div>
    
@endsection
