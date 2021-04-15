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
    Natalpro | All Vaccination Reminder Sms Samples
@endsection

@section('content') 

    @php($current_url = \Request::url())

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Vaccination Reminder Sms Samples <span class="badge badge-info">{{$count_vac_sms_samples}} </span></h3>
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
            
            <h2 class="add-ct-btn pull-right"><button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#vaccinationSampleFormModal" data-whatever="@mdo"><i class="mdi mdi-plus"></i> Add new vaccination sms sample</button></h2>

            <div style="clear:both;"></div>
            <br/>
            
            <div class="modal fade" id="vaccinationSampleFormModal" tabindex="-1" role="dialog" aria-labelledby="vaccinationSampleFormModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Vaccination SMS Sample Form</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="sms_sample_form" method="POST" onsubmit="return false">
                                {{csrf_field()}}

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Select Vaccination Interval</label>
                                    {!! Misc::selectVacIntervals() !!}
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Message in English Language</label>
                                    <textarea name="sms_english" id="sample_english_message" class="form-control" rows="5"></textarea>
                                    <small id="count_pages"></small>
                                </div>
                                
                                <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" id="translate_btn" onclick="return translateThis('#translate_btn', '#sms_sample_btn', '#sample_english_message', '#translate-status')"><i class="fa fa-exchange"></i> Translate</button>
                                <div id="translate-status"></div>

                                <div id="translate_div" style="display:none">
                                    <br/>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Yoruba Language</label>
                                        <textarea name="sms_yoruba" id="sms_yoruba" class="form-control" rows="5"></textarea>
                                        <small id="count_yoruba_pages"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Igbo Language</label>
                                        <textarea name="sms_igbo" id="sms_igbo" class="form-control" rows="5"></textarea>
                                        <small id="count_igbo_pages"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">Message in Hausa Language</label>
                                        <textarea name="sms_hausa" id="sms_hausa" class="form-control" rows="5"></textarea>
                                        <small id="count_hausa_pages"></small>
                                    </div>

                                </div>

                                <div class="modal-footer" style="border:0px">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="sms_sample_btn" style="display:none" onclick="return ajaxFormRequest('#sms_sample_btn','#sms_sample_form','/portal/controlling-room-admin/add-vaccination-sms-sample','POST','#sms_sample_status','Add','no')" class="btn btn-info">Add </button>
                                </div>
                                <div style="clear:both"></div>
                                <br/>
                                <div id="sms_sample_status" align="center"></div>
                                
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
        <div class="card">
            
            <div class="card-body">

            @if($count_vac_sms_samples == 0) 
                <div class="alert alert-danger" style="margin:0 auto"> No vaccination reminder sms samples yet </div>
            @else

                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Interval</th>
                                <th>SMS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($vac_sms_samples as $key=>$sms_sample)
                                
                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td>{!! Misc::selectedVacIntervals($sms_sample->vac_interval) !!}</td>
                                    <td>
                                        <button onclick="return smsSampleRequest('view','{{$sms_sample->vac_interval}}')" class="btn btn-sm btn-info"> View </button>
                                    </td>
                                    <td>
                                        <a href="#" onclick="return smsSampleRequest('edit','{{$sms_sample->vac_interval}}')" ><i class="fa fa-pencil"></i></a> &nbsp; &nbsp;

                                        <a href="{{$current_url}}/delete/{{$sms_sample->vac_interval}}" onclick="return confirm('Delete Sms Sample?')" class="text-danger"><i class="fa fa-trash"></i></a>
                                        <div id="sms-status{{$sms_sample->vac_interval}}"></div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br/><div class="pull-right"> {{$vac_sms_samples->links()}} </div>
                <br/>
            @endif
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
