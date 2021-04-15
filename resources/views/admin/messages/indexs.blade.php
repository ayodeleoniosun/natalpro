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

@extends('admin.pusher-app')

@section('title')
    NatalNurse | Admin | Inbox
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">Inbox</h3>
            </div>
        </div>
        
        <div style="margin:5px">
            
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

                    <div class="">
                    
                    @if( (count($unread_responses) == 0) && (count($unread_messages) == 0) && (count($read_responses) == 0) && (count($read_messages) == 0) ) 
                        <div class="alert alert-danger" style="margin:0 auto"> No inbox yet </div>
                    @else
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>User</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Sent on</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php($counter = 0)

                                    @if(count($unread_responses) > 0)

                                        @foreach($unread_responses as $key=>$unread_response) 

                                            @php($the_recipient = Query::getLastValue('inbox_responses', 'inbox_id', $unread_response->inbox_id, 'recipient'))

                                            @php($the_status = Query::getValue('inbox_responses', 'inbox_id', $unread_response->inbox_id, 'status'))
                                            
                                            @if($the_status == "pending" && $the_recipient == 'admin')
                                                
                                                @php($counter+=1)

                                                @php($created_at = Query::getLastValue('inbox_responses', 'inbox_id', $unread_response->inbox_id, 'created_at'))
                                                
                                                @php($sent_on = Dates::chatTimeAgo(strtotime($created_at), "three"))

                                                @php($encode_message = Misc::encoder($unread_response->inbox_id))

                                                @php($sender = Query::getLastValue('inbox_responses', 'inbox_id', $unread_response->inbox_id, 'sender'))

                                                @php($fullname = Query::getFullname('users', $sender))
                                                
                                                @php($subject = Query::getValue('inbox', 'id', $unread_response->inbox_id, 'subject'))

                                                @php($user_type = Query::getValue('users', 'id', $sender, 'user_type'))

                                                @php($the_message = Query::getLastValue('inbox_responses', 'inbox_id', $unread_response->inbox_id, 'response'))

                                                <tr style="font-weight:bold"> 
                                                    <td> {{$counter}} </td>
                                                    <td> 

                                                        @if($user_type == "pregnant-woman") 
                                                            <a href="/portal/portal/controlling-room-admin/pregnant-women/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Pregnant woman)  </small></a>
                                                        @elseif($user_type == "nursing-mothers") 
                                                            <a href="/portal/portal/controlling-room-admin/nursing-mothers/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Nursing mother) </small></a>
                                                        @else 
                                                            <a href="/portal/portal/controlling-room-admin/natal-nurses/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Natal nurse) </small></a>
                                                        @endif
                                                    </td>
                                                    <td><a href="portal/portal/controlling-room-admin/messages/view/{{$encode_message}}">{{ucfirst(substr($subject,0,40))}} ... </a></td>
                                                    <td class="max-texts"> <a href="portal/portal/controlling-room-admin/messages/view/{{$encode_message}}"> {{ucfirst(substr($the_message,0,60))}} </a></td>
                                                    <td><small> {{$sent_on}} </small></td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    @endif

                                    @if(count($unread_messages) > 0)

                                        @foreach($unread_messages as $unread_message) 

                                            @php($counter+=1)

                                            @php($created_at = Query::getValue('inbox', 'id', $unread_message->id, 'created_at'))
                                                
                                            @php($sent_on = Dates::chatTimeAgo(strtotime($created_at), "three"))

                                            @php($encode_message = Misc::encoder($unread_message->id))

                                            @php($sender = Query::getValue('inbox', 'id', $unread_message->id, 'sender'))

                                            @php($fullname = Query::getFullname('users', $sender))
                                            
                                            @php($subject = Query::getValue('inbox', 'id', $unread_message->id, 'subject'))

                                            @php($user_type = Query::getValue('users', 'id', $sender, 'user_type'))

                                            @php($the_message = Query::getValue('inbox', 'id', $unread_message->id, 'message'))
                                            
                                            <tr style="font-weight:bold"> 

                                                <!-- <td style="width:40px">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="checkbox{{$unread_message->id}}" value="{{$unread_message->id}}" name="message_id"/>
                                                        <label for="checkbox{{$unread_message->id}}"></label>
                                                    </div>
                                                </td> -->
                                                <td> {{$counter}}</td>
                                                <td>
                                                    
                                                    @if($user_type == "pregnant-woman") 
                                                        <a href="/portal/portal/controlling-room-admin/pregnant-women/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Pregnant woman)  </small></a>
                                                    @elseif($user_type == "nursing-mothers") 
                                                        <a href="/portal/portal/controlling-room-admin/nursing-mothers/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Nursing mother) </small></a>
                                                    @else 
                                                        <a href="/portal/portal/controlling-room-admin/natal-nurses/profile/{{$sender}}" class="text-info">{{$fullname}} <small>(Natal nurse) </small></a>
                                                    @endif

                                                </td>
                                                <td><a href="portal/portal/controlling-room-admin/messages/view/{{$encode_message}}">{{ucfirst(substr($subject,0,40))}} ... </a></td>
                                                <td class="max-texts"> <a href="portal/portal/controlling-room-admin/messages/view/{{$encode_message}}"> {{ucfirst(substr($the_message,0,60))}} ...</a></td>
                                                <td class="text-right"><small> {{$sent_on}} </small></td>
                                            </tr>
                                        @endforeach
                                            
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
