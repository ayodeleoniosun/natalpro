<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Users;
use App\Chats;
use App\Ratings;
use App\MyLib\Dates;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;
?>

@extends('admin.app')

@php($user_fullname = Query::getFullname('users', $the_user->id))

@section('title')
    Natalpro | {{$user_fullname}} Chats
@endsection

@section('content')
    
    @php($current_url = \Request::url())
    
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor">{{$user_fullname}} Chats</h3>
            </div>
        </div>
        
        <div class="container-fluid">
            
            <h2 class="add-ct-btn pull-left"><button onclick="return window.history.back()" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark"><i class="fa fa-arrow-circle-left"></i> Back</button></h2>

            <div style="clear:both;"></div>

            
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
                        
                    @if(count($chat_requests) == 0) 
                        <div class="alert alert-danger" style="margin:0 auto"> No chat yet </div>
                    @else
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Request ID</th>
                                        <th>Nurse</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Initiated On</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($chat_requests as $chat_request) 

                                        @php($chat_on = Dates::chatTimeAgo(strtotime($chat_request->created_at), "three"))

                                        @php($nurse_fullname = Query::getFullname('users', $chat_request->accepted_by))

                                        @php($count_messages = Chats::where('chat_req_id', $chat_request->id)->count())

                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a href="/portal/controlling-room-admin/chats/view/{{$chat_request->chat_req_id}}">
                                                {{str_replace("=", "",$chat_request->chat_req_id)}} ({{$count_messages}} messages)
                                            </a>
                                        </td>
                                        <td><a href="/portal/controlling-room-admin/natal-nurses/profile/{{$chat_request->accepted_by}}">{{ucfirst($nurse_fullname)}} </a></td>
                                        <td>
                                            @if($chat_request->done_status == "done")
                                                <button onclick="return viewFeedbacks('admin','{{$chat_request->id}}')" class="btn btn-sm btn-info"> View </button>
                                                <br/>
                                                <small id="feedback-status{{$chat_request->id}}"></small>
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td>
                                            @if($chat_request->done_status == "done")
                                                <span class='label label-primary'><i class="fa fa-check"></i> Done </span>
                                            @else
                                                <span class='label label-success'> {{$chat_request->done_status}} ...</span>
                                            @endif
                                        </td>
                                        <td><small> {{$chat_on}} </small></td>
                                    </a>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br/>
                        <div style="clear:both"></div>
                        <div class="pull-right"> {{$chat_requests->links()}} </div><br/>
                        
                    @endif
                     <br/>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>
</div>
    
@endsection
