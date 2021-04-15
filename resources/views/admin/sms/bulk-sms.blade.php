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
    NatalPro | Bulk SMS
@endsection

@section('content') 

    @php($current_url = \Request::url())
    @php($sms_balance = Misc::smsBalance())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Sent SMS <span class="badge badge-info">{{$count_bulk_sms}} </span></h3>
            </div>
        </div>
        
        <div class="container-fluid">
           <small style="font-size:15px"> Your SMS Balance is <b> {!! Misc::smsBalance() !!} units </b>.
                
                @if(ceil($sms_balance) < 200)
                    Click <a href='https://smartsmssolutions.com/sms/buy-sms-online' target='_blank'><b>HERE</b></a> to top up your units to ensure the continuity of sms
                @endif
            <div style="clear:both"></div>
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
            
            <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#SmsFormModal" data-whatever="@mdo"><i class="mdi mdi-plus"></i> Send new sms</button></h2>
            <div style="clear:both;"></div>

            <div class="modal fade" id="SmsFormModal" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Send SMS </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="bulk_sms_form" method="POST" onsubmit="return false">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Sender</label> 
                                    <small>(<i> Max. of 11 characters</i>)</small>
                                    <input class="form-control" type="text" name="sender" required="" maxlength="11" value="Natalpro"/> 
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Recipients</label> <br/>
                                    <small>(<i> Kindly seperate multiple contacts by commas</i>) </small><br/>
                                    <input class="form-control" type="text" name="recipients" required="" placeholder="E.g 08128282, 09028282, 08028282"/> 
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Message</label>
                                    <textarea name="sms" id="sample_english_message" class="form-control" rows="5"></textarea>
                                    <small id="count_pages"></small>
                                </div>
                                
                                <div class="modal-footer" style="border:0px">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="sms_btn" onclick="return ajaxFormRequest('#sms_btn','#bulk_sms_form','/portal/controlling-room-admin/send-sms','POST','#sms_status','Send','no')" class="btn btn-info">Send </button>
                                </div>
                                <div style="clear:both"></div>
                                <br/>
                                <div id="sms_status" align="center"></div>
                                
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
            

            @if($count_bulk_sms == 0) 
                <div class="alert alert-danger" style="margin:0 auto"> No bulk sms yet </div>
            @else

                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Sender</th>
                                <th>SMS</th>
                                <th>Sent on</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($bulk_sms as $key=>$sms)
                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td> {{$sms->sender}} </td>
                                    <td> 
                                        <button onclick="return bulkSmsRequest('{{$sms->id}}')" class="btn btn-sm btn-info"> View </button>
                                        <div id="sms-status{{$sms->id}}"></div>
                                    </td>
                                    <td> {!! Dates::formatDate($sms->created_at, "three") !!}  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br/><div class="pull-right"> {{$bulk_sms->links()}} </div>
                <br/>
            @endif
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
