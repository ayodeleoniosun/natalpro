<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use App\MyLib\Misc;
?>

@extends('natal-nurses.pusher-app')

@section('title')
    Natalpro | Chat with {{$patient_fullname}}
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Chat with {{$patient_fullname}}</h3>
            </div>
        </div>
    
        <div class="container-fluid">
            
            <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>

            <div style="clear:both;"></div>

            
            
            <div class="row card">
                <div class="card-body">
                
                @if($chat_request_status == "pending")
                    <div style="font-size:14px" class="pull-left"><b> Start chatting now </b></div>
                    <div class="pull-right"><button onclick="return allowFeedback('{{$req_id}}', '{{$request_id}}')" class="btn btn-sm btn-info" id="allow_feedback_btn{{$request_id}}"><i class="fa fa-comments"></i> Allow feedback from patient</button> </div> <br/><p></p>
                    <small id="feedback-status{{$request_id}}" class="pull-right"></small> <br/>
                    <hr/>
                @else
                    <div style="font-size:18px" class="pull-left"><b> Chat preview </b></div><br/><hr/>
                @endif
                
                <script type="text/javascript">
                    $(document).ready(function() {
                        ajaxLoadingRequest('/portal/natal-nurse/chat-messages/{{$req_id}}', '#chat_messages', '', 'GET');
                    });
                </script>

                <ul class="chat-list p-20 vertical-scroll" id="chat_messages"></ul>
                
                <div style="clear:both"></div>
                
                @if($chat_request_status == "pending")
                    <form class="form-horizontal" id="chat-form" method="POST" onsubmit="return false">
                        {{csrf_field()}}

                        <input type="hidden" name="the_request" value="{{$req_id}}"/>
                        
                        <textarea name="message" id="message" class="form-control" rows="7" placeholder="Type your chat below"></textarea>
                        
                        <button type="button" id="chat-btn" style="display:none" onclick="return ajaxFormRequest('#chat-btn','#chat-form','/portal/natal-nurse/send-chat','POST','#chat-status','Send','no')" class="btn btn-info pull-right"> Send </button>
                        <div style="clear:both"></div>
                        
                        <div id="chat-status" align="center"></div>
                        
                    </form>
                @endif    
            </div>
        </div>
    </div>
    
            @include('pregnant-nursing-women.footer')
    
@endsection
