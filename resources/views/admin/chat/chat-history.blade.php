<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\MyLib\Misc;
?>

@extends('admin.app')

@section('title')
    Natalpro | Chat between {{$patient}} and Nurse {{$nurse}} ({{str_replace("=","",$req_id)}})
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Chat between {{$patient}} and Nurse {{$nurse}}  ({{str_replace("=","",$req_id)}})</h3>
            </div>
        </div>
    
        <div class="container-fluid">
            
            <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>

            <div style="clear:both;"></div>

            
            <div class="card">
                <div class="card-body">
                
                <div style="font-size:18px" class="pull-left"><b> Chat preview </b></div><br/><hr/>
                
                <script type="text/javascript">
                    $(document).ready(function() {
                        ajaxLoadingRequest('/portal/controlling-room-admin/chat-messages/{{$req_id}}', '#chat_messages', '', 'GET');
                    });
                </script>

                <ul class="chat-list p-20 vertical-scroll" id="chat_messages"></ul>
                
                <div style="clear:both"></div>
                
            </div>
        </div>
    </div>
    
    @include('admin.footer')
    
@endsection
