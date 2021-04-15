<?php

namespace App\Http\Controllers;
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

@extends('admin.app')

@section('title')
    Natalpro | Admin | Settings
@endsection

@section('content')
    
    @php($current_url = \Request::url())
    
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Settings</h3>
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
                    
                    <h3> Update Prices </h3> <hr/>

                    <form class="form-horizontal" id="settings-form" action="#" method="post" onsubmit="return false">
                        
                        {{csrf_field()}}

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination price </label>
                                <input class="form-control" type="text" name="vac_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->vac_amount}}"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Chat price </label>
                                <input class="form-control" type="text" name="chat_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->chat_amount}}"/> </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Kit price </label>
                                <input class="form-control" type="text" name="kit_amount" required="" onkeypress="return isCharNumber(event)" value="{{$settings->kit_amount}}"/> </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label> Vaccination reminder welcome message </label> <br/>
                                <small> (<i> Ensure that this is not more than a page in order to conserve SMS units </i>)</small>
                                <textarea name="welcome_message" id="sample_english_message" class="form-control" rows="5">{{$settings->welcome_message}}</textarea>
                                <small id="count_pages"></small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-info" id="settings-btn" onclick="return ajaxFormRequest('#settings-btn','#settings-form','/portal/controlling-room-admin/update-settings','POST','#settings-status','Save changes','no')"><i class="fa fa-check"></i> Save changes </button> <br/>
                                <div id='settings-status' align='center'></div>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
