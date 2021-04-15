<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\Inbox;
use DB;
?>

@extends('natal-nurses.pusher-app')

@section('title')
    Natalpro | {{$the_message->subject}}
@endsection

@section('content')
    
    @php($responses = Inbox::find($the_message->id)->inboxresponses)

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12">
                <h3 class="text-themecolor">{{$the_message->subject}}</h3>
            </div>
        </div>
        
        <div class="container-fluid">

        <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>
        <div style="clear:both;"></div>
        <br/>
            
        <div class="card">
            <div class="card-body">
                
                <small style="font-size:14px"> {!! html_entity_decode(ucfirst(nl2br($the_message->message))) !!} </small>

                <hr/>

                <script type="text/javascript">
                    $(document).ready(function() {
                        var url = "/portal/natal-nurse/messages/responses/{!!Misc::encoder($the_message->id)!!}"
                        ajaxLoadingRequest(url, '#all_responses', '', 'GET');
                    });
                </script>
                
                <div class=" vertical-scroll" id="scroll_responses">
                    <ul class="chat-list p-20" id="all_responses"></ul>
                    <ul class="chat-list p-20" id="private_chat{{$encrypted_message_id}}"></ul>
                </div>

                <form class="form-horizontal" id="response_form" method="POST" onsubmit="return false">
                    {{csrf_field()}}

                    <input type="hidden" name="inbox" value="{!! Misc::encoder($the_message->id) !!}"/>
                    
                    <div class="form-group">
                        <textarea name="message" id="pm_message" class="form-control" rows="7" placeholder="Type your response below"></textarea>
                    </div>

                    <button type="button" id="response_btn" style="display:none" onclick="return ajaxFormRequest('#response_btn','#response_form','/portal/natal-nurse/respond','POST','#response_status','Send','no')" class="btn btn-info pull-right"> Send </button>
                    <div style="clear:both"></div>
                    
                    <div id="response_status" align="center"></div>
                    
                </form>
            </div>
        </div>
                
        </div>
    </div>    
@endsection
